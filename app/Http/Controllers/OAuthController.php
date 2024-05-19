<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Laravel\Socialite\Facades\Socialite;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

use Illuminate\Validation\Rule;

use Illuminate\Auth\Events\Registered;

class OAuthController extends Controller
{
    public function auth($provider = 'doximity') {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider = 'doximity') {
        $oAuthUser = Socialite::driver($provider)->user();

        $names = explode(" ",$oAuthUser->name,2);

        // check for current user
        $currentUser = User::where(['email' => $oAuthUser->email])->first();
        if ($currentUser != null && $currentUser->oauth_provider != $provider) {
            if ($currentUser->oauth_provider==null) {
                return redirect()->route('register')->with('oauth-error',config('messages.oauth-error'));
            } else {
                return redirect()->route('register')->with('oauth-error',config('messages.oauth-error-services'));
            }
        }

        $currentUserFromOauth = User::where([
            'oauth_provider' => $provider,
            'oauth_user_id' => $oAuthUser->id
        ])->first();

        $update = [
            'first_name' => $names[0],
            'last_name' => $names[1] ?? ' ',
            'oauth_token' => $oAuthUser->token,
            'oauth_refresh_token' => $oAuthUser->refreshToken,
            'profile_image' => $oAuthUser->getAvatar(),
        ];

        if (!($currentUserFromOauth != null && $provider == 'doximity')) {
            $update['email'] = $oAuthUser->email;
        }

        $user = User::updateOrCreate([
            'oauth_provider' => $provider,
            'oauth_user_id' => $oAuthUser->id,
        ], $update);

        $user->markEmailAsVerified();

        event(new Registered($user));

        Auth::login($user);

        return redirect('/dashboard');
    }

    public function completeRegistration() {
        return view('auth.complete-registration');
    }

    public function finishRegistration(Request $request) {
        $user = Auth::user();

        $validate = [
            'role' => ['required', Rule::in(['student', 'preceptor'])],
            'school' => ['nullable', 'string', 'max:255'],
            'career' => ['nullable', 'string', 'max:255'],
            'studentType' => ['nullable', 'string', 'max:255'],
        ];

        if (str_ends_with($user->email, '@temp.findarotation.com')) {
            $validate['email'] = ['required', 'string', 'email', 'max:255', 'unique:users'];
        }

        $request->validate($validate);

        if (str_ends_with($user->email, '@temp.findarotation.com')) {
            $user->email = $request->email;
        }

        $user->role =  $request->role;
        $user->school = $request->school;
        $user->career_id = $request->career;
        $user->student_type_per_careers_id = $request->studentType;
        $user->save();

        return redirect('/dashboard');
    }
}
