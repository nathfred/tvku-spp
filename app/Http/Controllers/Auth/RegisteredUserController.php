<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register', [
            'title' => 'Register',
            'active' => 'register'
        ]);
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required'],
            'code' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($request->code == env('DIRECTOR_CODE', 'directortvkuch49')) {
            $user = User::create([
                'name' => $request->name,
                'role' => 'director',
                'gender' => $request->gender,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        } elseif ($request->code == env('EMPLOYEE_CODE', 'employee')) {
            $user = User::create([
                'name' => $request->name,
                'role' => 'employee',
                'gender' => $request->gender,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        } else {
            return back()->with('message', 'code-error');
        }

        event(new Registered($user));

        Auth::login($user);

        if ($request->code == env('DIRECTOR_CODE', 'directortvkuch49')) {
            return redirect(RouteServiceProvider::HOME_DIRECTOR);
        } elseif ($request->code == env('EMPLOYEE_CODE', 'employee')) {
            return redirect(RouteServiceProvider::HOME_EMPLOYEE);
        } else {
            return back()->with('message', 'code-error');
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
