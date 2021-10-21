<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Assignment;
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

    public function back()
    {
        return redirect()->back();
    }

    public function test_DOMPDF($id)
    {
        $assignment = Assignment::where('id', $id)->first();
        // VALIDASI APAKAH ASSIGNMENT ADA
        if ($assignment === NULL) {
            return back()->with('message', 'assignment-not-found');
        }

        $date = Carbon::createFromFormat('Y-m-d', $assignment->created);
        $month = $date->month;
        $assignment->month_roman = $this->numberToRoman($month);
        $assignment->year = $date->year;

        return view('spp_pdf', [
            'assignment' => $assignment,
        ]);
    }

    function numberToRoman($number)
    {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if ($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }
}
