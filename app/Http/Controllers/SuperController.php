<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class SuperController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('super.index', [
            'title' => 'Super Index',
            'active' => 'index',
            'users' => $users,
        ]);
    }

    public function show_user($id)
    {
        $user = User::where('id', $id)->first();

        return view('super.user_profile', [
            'title' => 'Super Index',
            'active' => 'index',
            'user' => $user,
        ]);
    }

    public function edit_user(Request $request, $id)
    {
        $user = User::find($id);

        // CEK APAKAH ADA
        if ($user === NULL) {
            return back()->with('message', 'user-not-found');
        }

        // VALIDASI
        if ($user->email == $request->email) { // JIKA GANTI EMAIL
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:64']
            ]);
        } else { // JIKA EMAIL TETAP SAMA
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:64', 'unique:users']
            ]);
        }

        $request->validate([
            'name' => ['required', 'string', 'min:4', 'max:255'],
            'gender' => ['required'],
            'email' => ['required', 'string', 'email', 'max:64'],
        ]);

        // UPDATE ATTRIBUTE
        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->email = $request->email;
        $user->save();

        return redirect(route('super-show-user', ['id' => $user->id]))->with('message', 'success-update-user');
    }

    public function edit_user_password($id)
    {
        $user = User::find($id);

        // CEK APAKAH ADA
        if ($user === NULL) {
            return back()->with('message', 'user-not-found');
        }

        return view('super.user_password', [
            'title' => 'Edit Password',
            'active' => 'admin',
            'user' => $user,
        ]);
    }

    public function save_user_password(Request $request, $id)
    {
        $user = User::find($id);

        // CEK APAKAH ADA
        if ($user === NULL) {
            return back()->with('message', 'user-not-found');
        }

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect(route('super-show-user', ['id' => $user->id]))->with('message', 'success-update-user-password');
    }
}
