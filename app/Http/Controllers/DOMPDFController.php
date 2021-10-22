<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\Assignment;
use Illuminate\Http\Request;

class DOMPDFController extends Controller
{
    public function createPDF($id)
    {
        $assignment = Assignment::where('id', $id)->first();
        // VALIDASI APAKAH ASSIGNMENT ADA
        if ($assignment === NULL) {
            return back()->with('message', 'assignment-not-found');
        }

        // BUAT ROMAWI UNTUK BULAN
        $date = Carbon::createFromFormat('Y-m-d', $assignment->created);
        $day = $date->day;
        $assignment->day = $day;
        $month = $date->month;
        $assignment->month = $month;
        $assignment->month_roman = $this->numberToRoman($month);
        $month_string = $date->locale('id')->monthName;
        $assignment->month_string = $month_string;
        // BUAT TAHUN
        $assignment->year = $date->year;
        // UBAH FORMAT KE d-m-Y
        $assignment->created = $date->format('d-m-Y');

        // SPLIT ATTRIBUT 'info' (text data type in MySQL) to array
        $array_info = preg_split('/\r\n|[\r\n]/', $assignment->info);
        $assignment->array_info = $array_info;

        $pdf = PDF::loadview('spp_pdf', ['assignment' => $assignment]);
        return $pdf->download('SPP_' . $assignment->nspp . '_' . $assignment->type);
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
