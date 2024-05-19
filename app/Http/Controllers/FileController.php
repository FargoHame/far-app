<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\FileType;
use App\Traits\FileTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class FileController extends Controller
{
    use FileTrait;

    public function documents() {
        $data=$this->findDocumentTypes();
        return view('student.documents',['documents' => $data['documents'],'filesType' => $data['filesType'] ]);
    }

    public function findDocumentTypes() {

        $user = Auth::user();
        $documents = File::where(['user_id' => $user->id, 'is_manageable' => 1])->orderBy('created_at','DESC')->get();
        foreach ($documents as $document) {
            $data[] = $document->file_type_id;
        }
        if (isset($data)){
            $filesType = FileType::whereNotIn('id' , $data)->orderBy('created_at','DESC')->get();
        }
        else
            $filesType = FileType::all();

        return['documents' => $documents,'filesType' => $filesType ];
    }

    public function store(Request $request) 
    {
        // remove documents from the list
        if (isset($request->delete)) {
            $file = File::find($request->delete);
            $file->is_manageable = false;
            $file->save();
            // foreach ($request->filedelete as $fileDelete) {
            //     $file = File::find($fileDelete);
            //     $file->is_manageable = false;
            //     $file->save();
            // }
        } else {
            $filesType = FileType::all();
            foreach ($filesType as $fileType) {
                $fileUp = $request->file('fileid' . $fileType->id);
                $fileUpdate = File::where(['file_type_id' => $fileType->id, 'is_manageable' => 1])->first();
                if (isset($fileUpdate) && isset($fileUp)) {
                    $fileUpdate->is_manageable = false;
                    $fileUpdate->save();
                }
                if (isset($fileUp)) {
                    $this->upFile($fileUp, $fileType->id, true);
                }
            }
        }
        return redirect()->route('documents');
    }
}
