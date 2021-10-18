<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function home()
    {
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();

        if ($user->role == 'director') {
            return redirect()->route('director-index');
        } elseif ($user->role == 'employee') {
            return redirect()->route('employee-index');
        } else {
            return redirect()->route('login');
        }
    }
}
