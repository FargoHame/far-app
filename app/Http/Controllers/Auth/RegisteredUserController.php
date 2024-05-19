<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Traits\GigWageTrait;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    use GigWageTrait;

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register',['referral_code' => '']);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request)
    {

        // check for current user
        $currentUser = User::where(['email' => $request->email])->first();
        if ($currentUser != null ) {
                return redirect()->route('register')->with('oauth-error',config('messages.oauth-error'));
        }

        DB::beginTransaction();
        $flag=true;
        $request->validate([
            'role' => ['required', Rule::in(['student', 'preceptor', 'affiliate'])],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'school' => ['nullable', 'string', 'max:255'],
            'degree' => ['nullable', 'string', 'max:255'],
            'career' => ['nullable', 'string', 'max:255'],
            'studentType' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'role' => $request->role,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'school' => $request->school,
            'degree' => $request->degree,
            'password' => Hash::make($request->password),
            'affiliate_id' => Str::random(6),
            'referral_code' => $request->referral_code,
            'career_id' => $request->career,
            'student_type_per_careers_id' => $request->studentType
        ]);

        if ($request->role == 'preceptor') {
            $flag = $this->registreContractor($user->role, $request->email, $request->first_name, $request->last_name, $user->id);
        }

        if ($flag)
        {
            DB::commit();
            event(new Registered($user));
            Auth::login($user);
        }
        else
        {
            DB::rollback();
        }

        return redirect(RouteServiceProvider::HOME);
    }

    public function affiliate()
    {
        return view('auth.AffiliateRegister');
    }

}
