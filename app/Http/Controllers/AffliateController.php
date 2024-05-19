<?php

namespace App\Http\Controllers;

use App\Traits\GigWageTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffliateController extends Controller
{
    use GigWageTrait;

    public function connect() {

        if (Auth::user()->gigwage_id != null)
            return view('affliate.sucess-notify');

        return view('affliate.connect-account',[]);
    }

    public function store(Request $request)
    {
        $rules = array(
            'email' => 'required|exists:users',
            'first_name' => 'required',
            'last_name' => 'required'
        );

        $validator = Validator::make($request->all(),$rules);
        $user=Auth::user();

        $response = $this->registreContractor($user->role ,$request->email,$request->first_name,$request->last_name,$user->id,$validator);
        if ($response)
        return redirect()->route('connect-account');
        else
         return redirect()->route('connect-account')->withErrors($validator);

    }


}
