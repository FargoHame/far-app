<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Message;
use App\Models\File;
use App\Models\Application;

use Illuminate\Support\Facades\Mail;
use App\Mail\NewMessageMail;

class MessagesController extends Controller
{
    public function messages(Request $request)
    {
        $user = Auth::user();

        if ($user->role == "preceptor") {
            $messages = Message::whereHas('application', function ($query) use ($user) {
                $query->whereHas('rotation', function ($q) use ($user) {
                    $q->where(['preceptor_user_id' => $user->id]);
                });
            })->where('user_id', '<>', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(config("rotation.pagination_size"));
        } elseif ($user->role == "student") {
            if (!isset($request->rotation)) {
                $messages = Message::whereHas('application', function ($query) use ($user) {
                    $query->where(['student_user_id' => $user->id]);
                })->where('user_id', '<>', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(config("rotation.pagination_size"));
            } else {
                $messages = Message::whereHas('application', function ($query) use ($user, $request) {
                    $query->where(['student_user_id' => $user->id, 'rotation_id' => $request->rotation]);
                })->where('user_id', '<>', $user->id);
                if (count($messages->get()) > 0) {
                    return redirect()->route('student-application-view', ['application' => $messages->get()->first()->application_id]);
                } else {
                    $messages = [];
                }
            }
        } else {
            abort(404);
        }

        return view('messages',['messages' => $messages]);
    }

    public function sendMessage(Request $request) {
        $message = new Message();
        $message->application_id = $request->application_id;
        $message->user_id = Auth::user()->id;
        $message->message = $request->message;
        $message->save();

        $application = Application::find($request->application_id);

        if ($request->file('file')!=null) {
            $path = $request->file('file')->store('message');
            $file = new File();
            $file->user_id = Auth::user()->id;
            $file->filename = $request->file('file')->getClientOriginalName();
            $file->path = $path;
            $file->save();

            $message->files()->attach($file);

            $application->files()->attach($file);
        }


        if (Auth::user()->role=="preceptor") {
            Mail::to([$message->application->student->email])->queue(new NewMessageMail($message,$message->application->student));

        } else {
            Mail::to([$message->application->rotation->preceptor->email])->queue(new NewMessageMail($message,$message->application->rotation->preceptor));
        }

        Message::where('application_id', '=', $message->application_id)->where('user_id', '<>', $message->user_id) ->update(['viewed_at' => now()]);
        $messageNew = Message::where(['id' => $message->id])->orderBy('created_at','ASC')->get();
        $messages_transmitter=view('messages-transmitter', ['messages' => $messageNew])->render();
        $messages_receiver=view('messages-receiver', ['messages' => $messageNew])->render();

        event(new NewMessage($message->application_id,$messages_receiver,$message->user_id));

        return response()->json(['message'=>$messages_transmitter]);
    }
}
