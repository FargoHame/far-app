<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUsersController extends Controller
{

    public function edit(User $user) {
        return view('admin.user-edit',['user' => $user]);
    }

    public function updateBio(Request $request) {
        $user = User::findOrFail($request->id);
        if ($user->role == 'admin') {
          abort(403, 'Unauthorized action.');
        }

        $validations = [
          'first_name' => 'required|string|max:255',
          'last_name' => 'required|string|max:255',
          'email' => 'required|email'
        ];

        $validatedData = $request->validateWithBag('userBioErrors', $validations);
        $user->fill($validatedData);
        $user->save();

        return redirect()->route('admin-user-edit', ['user' => $user])->with('userBioStatus', 'Biodata updated.');
    }

    public function updateProfessional(Request $request) {
      $user = User::findOrFail($request->id);
      if ($user->role == 'admin') {
        abort(403, 'Unauthorized action.');
      }

      $validations = [
        'school' => 'required|string|max:255',
        'degree' => 'required|string|max:255'
      ];

      $validatedData = $request->validateWithBag('userProfessionalErrors', $validations);
      $user->fill($validatedData);
      $user->save();

      return redirect()->route('admin-user-edit', ['user' => $user])->with('userProfessionalStatus', 'Professional details updated.');
  }

  public function updatePhoto(Request $request) {
    $user = User::findOrFail($request->id);
    if ($user->role == 'admin') {
      abort(403, 'Unauthorized action.');
    }

    $validations = [
      'photo' => 'image|mimes:jpeg,png,jpg,svg|max:2048'
    ];

    $validatedData = $request->validateWithBag('userPhotoErrors', $validations);

    $path = $request->file('photo')->store('public');

    $user->profile_image = $path;
    $user->save();

    return redirect()->route('admin-user-edit', ['user' => $user])->with('userPhotoStatus', 'Profile picture updated.');
  }

  public function updatePassword(Request $request) {
      $user = User::findOrFail($request->id);
      if ($user->role == 'admin') {
        abort(403, 'Unauthorized action.');
      }

      $validations['password'] = 'required|string|min:8|confirmed';
      $validatedData = $request->validateWithBag('userPasswordErrors', $validations);

      $user->fill($validatedData);
      $user->password = Hash::make($request->password);
      $user->save();

      return redirect()->route('admin-user-edit',['user' => $user])->with('userPasswordStatus', 'Password updated.');
  }
}
