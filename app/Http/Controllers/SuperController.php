<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
}
