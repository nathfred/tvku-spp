<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Assignment;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRController extends Controller
{
    public function generate($id)
    {
        $assignment = Assignment::findOrFail($id);

        $base_url = env('URL_LOCAL', '130.30.1.14:7085');
        $route_url = '/validate/spp/';
        $qrcode = QrCode::size(100)->generate($base_url . $route_url  . $assignment->unique_id, '../public/qrcodes/spp_validation_' . $assignment->id . '.svg');

        return view('qrcode', compact('qrcode'));
    }

    public function scan($id)
    {
        // AMBIL ASSIGNMENT DARI UNIQUE_ID
        $assignment = Assignment::where('unique_id', $id)->first();
        if (!$assignment || $assignment === NULL) {
            return response()->view('sitemap_error')->header('Content-Type', 'text/xml');
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
        $assignment->year = $date->year;

        // MODIF ISI DATA ASSIGNMENT
        // UBAH KE FORMAT CARBON
        $assignment->created = Carbon::createFromFormat('Y-m-d', $assignment->created);
        $assignment->approval_date = Carbon::createFromFormat('Y-m-d', $assignment->approval_date);
        // UBAH FORMAT KE d-m-Y
        $assignment->created = $assignment->created->format('d-m-Y');
        $assignment->approval_date = $assignment->approval_date->format('d-m-Y');

        // NOMINAL
        if ($assignment->nominal) {
            $assignment->nominal = 'Rp. ' .  number_format($assignment->nominal, 0, ",", ".");
        }

        // APPROVAL
        if ($assignment->approval == 1) {
            $assignment->approve = 'Disetujui';
        } elseif ($assignment->approval == 0) {
            $assignment->approve = 'Tidak Disetujui';
        }

        // SPP
        if ($assignment->type == 'Free') {
            $spp_ket = '/FREE/SPP-D/';
        } elseif ($assignment->type == 'Berbayar') {
            $spp_ket = '/SPP-D/';
        } elseif ($assignment->type == 'Barter') {
            $spp_ket = '/BARTER/SPP-D/';
        } else {
            $spp_ket = '/SPP-D/';
        }
        $assignment->nspp = $assignment->nspp . $spp_ket . $assignment->month_roman . '/TVKU/' . $assignment->year;

        // INVOICE
        if ($assignment->type == 'Berbayar') {
            $assignment->invoice = 'Invoice Nomor I-' . $assignment->nspp . '/KEU/TVKU/' . $assignment->month_roman . '/' . $assignment->year;
        }

        // RETURN XML
        return response()->view('sitemap', [
            'assignment' => $assignment,
        ])->header('Content-Type', 'text/xml');
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
