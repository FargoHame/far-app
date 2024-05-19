<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App;
use App\Models\Specialty;
use App\Models\User;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
      // check if the url has the ref id to get the prefinary data. this is for new users
        if ($request->ref) {
            $hash = hash_hmac(
                'sha256', // hash function
                $request->ref, // user's email, referral code, or id
                'Lu3dEGf5KpxcddocGaFnkVZw' // secret key (keep safe!)
            );
      // use the email to get the prefinary data
        } else {
            $hash = hash_hmac(
                'sha256', // hash function
                Auth::user()->email, // user's email, referral code, or id
                'Lu3dEGf5KpxcddocGaFnkVZw' // secret key (keep safe!)
            );
        }
        $social = '';
        if (Auth::user()->social_links != null) {
            $social = json_decode(Auth::user()->social_links, true);
        }
        $specialty = null;
        if (Auth::user()->speciality != null) {
            $specialty = json_decode(Auth::user()->speciality);
        }
        return view('profile', ['hash' => $hash,'prefinay' => Auth::user()->code_prefinary, 'social' => $social, 'specialties' => $specialty]);
    }
    public function prefinary($request)
    {
      // save prefinary id on the database
      Auth::user()->where('id', Auth::user()->id)->update(array('code_prefinary' => $request));
      return redirect()->route('profile');
    }
    public function uploadToS3($request)
    {
        $path = $request->file('photo');
        $name = $request->file('photo')->hashName();
        try {
            $s3 = App::make('aws')->createClient('s3');
            $path = $s3->putObject(array(
                'Bucket'     => env('AWS_BUCKET', ''),
                'Key'        => 'user images/' . $name,
                'SourceFile' => $path,
                'visibility' => 'public',
            ));
            return $path['ObjectURL'];
        } catch (\exception $e) {
            return '';
        }
    }

    public function updateBio(Request $request)
    {
        $validations = [
          'first_name' => 'required|string|max:255',
          'last_name' => 'required|string|max:255'
        ];

        $validatedData = $request->validateWithBag('profileBioErrors', $validations);

        $current_user = Auth::user();
        $current_user->fill($validatedData);
        if (isset($request->description)) {
            $current_user->description = $request->description;
        }
        if (isset($request->company)) {
            $current_user->company = $request->company;
        }
        if (isset($request->specialities)) {
            $current_user->speciality = json_encode($request->specialities);
        }
        if (isset($request->role)) {
            $current_user->role = $request->role;
        }
        if (isset($request->photo)) {
            $url = $this->uploadToS3($request);
            if ($url != '') {
                $current_user->profile_image = $url;
            }
        }
        if (isset($request->location)) {
            $current_user->location = $request->location;
        }
        $social = [];
        if (isset($request->linkedin)) {
            $social['linkedin'] = $request->linkedin;
        }
        if (isset($request->facebook)) {
            $social['facebook'] = $request->facebook;
        }
        if (isset($request->twitter)) {
            $social['twitter'] = $request->twitter;
        }
        if (isset($request->instagram)) {
            $social['instagram'] = $request->instagram;
        }
        if (count($social) > 0) {
            $current_user->social_links = json_encode($social);
        }
        if (isset($request->school)) {
            $current_user->school = $request->school;
        }
        if (isset($request->degree)) {
            $current_user->degree = $request->degree;
        }
        $current_user->save();

        return redirect()->route('profile')->with('profileBioStatus', 'Your biodata has been updated.');
    }

    public function updatePhoto(Request $request) {
      $validations = [
        'photo' => 'image|mimes:jpeg,png,jpg,svg|max:2048'
      ];

      $validatedData = $request->validateWithBag('profilePhotoErrors', $validations);

      $path = $request->file('photo');
      $name= $request->file('photo')->hashName();
      $current_user = Auth::user();
        try {
            $s3 = App::make('aws')->createClient('s3');
            $path = $s3->putObject(array(
                'Bucket'     => env('AWS_BUCKET', ''),
                'Key'        => 'user images/'.$name,
                'SourceFile' => $path,
                'visibility' => 'public',
            ));
            $current_user->profile_image = $path['ObjectURL'];
            $current_user->save();

            return redirect()->route('profile')->with('profilePhotoStatus', 'Your profile picture has been updated.');

        }catch (\exception $e){
            return redirect()->route('profile')->with('profilePhotoError', $e->getMessage());
        }
  }

    public function updateProfessional(Request $request) {
      $validations = [
        'school' => 'required|string|max:255',
        'degree' => 'required|string|max:255'
      ];

      $validatedData = $request->validateWithBag('profileProfessionalErrors', $validations);

      $current_user = Auth::user();
      $current_user->fill($validatedData);

      $current_user->save();

      return redirect()->route('profile')->with('profileProfessionalStatus', 'Your professional details have been updated.');
  }

    public function updatePassword(Request $request) {
      $validations['password'] = 'required|string|min:8|confirmed';
      $validatedData = $request->validateWithBag('profilePasswordErrors', $validations);

      $current_user = Auth::user();
      $current_user->fill($validatedData);
      $current_user->password = Hash::make($request->password);

      $current_user->save();

      return redirect()->route('profile')->with('profilePasswordStatus', 'Your password has been updated.');
  }
    public function publicProfile(Request $request)
    {
        $user = User::find($request->id);
        if ($user->social_links != null) {
            $user->social_links = json_decode($user->social_links, true);
        }
        if ($user->speciality != null) {
            $specialties = [];
            foreach (json_decode($user->speciality) as $key => $value) {
                $specialties[$key] = Specialty::find($value)->name;
            }
            $user->speciality = $specialties;
        }
        // dd($user);
        return view('public-profile', compact('user'));
    }
    public function removeFile(Request $request)
    {
        if ($request->file != null) {
            try {
                $s3 = App::make('aws')->createClient('s3');
                $s3->deleteObject([
                    'Bucket'     => env('AWS_BUCKET', ''),
                    'Key'        => $request->file
                ]);
                $current_user = Auth::user();
                $current_user->profile_image = null;
                $current_user->save();

                return redirect()->route('profile');

            } catch (\exception $e){
                dd($e);
                return redirect()->route('profile')->with('profilePhotoError', $e->getMessage());
            }
        }
    }
    public function getStudentsTypes(Request $req)
    {
        $data = \App\Models\StudentTypePerCareer::getStudentTypePerCareers($req->id);
        return response()->json(['data' => $data]);
    }
}
