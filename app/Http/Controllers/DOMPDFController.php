<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;
use PDF;

class DOMPDFController extends Controller
{
    public function cetak_pdf($id)
    {
        $assignment = Assignment::where('id', $id)->first();
        // VALIDASI APAKAH ASSIGNMENT ADA
        if ($assignment === NULL) {
            return back()->with('message', 'assignment-not-found');
        }

        $pdf = PDF::loadview('pegawai_pdf', ['assignment' => $assignment]);
        return $pdf->download('laporan-pegawai-pdf');
    }
}
