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

        // MODIF ISI DATA ASSIGNMENT
        // UBAH KE FORMAT CARBON
        $assignment->created = Carbon::createFromFormat('Y-m-d', $assignment->created);
        // UBAH FORMAT KE d-m-Y
        $assignment->created = $assignment->created->format('d-m-Y');
        if ($assignment->nominal) {
            $assignment->nominal = 'Rp. ' .  number_format($assignment->nominal, 0, ",", ".");
        }
        if ($assignment->approval == 1) {
            $assignment->approve = 'Disetujui';
        } elseif ($assignment->approval == 0) {
            $assignment->approve = 'Tidak Disetujui';
        }

        // RETURN XML
        return response()->view('sitemap', [
            'assignment' => $assignment,
        ])->header('Content-Type', 'text/xml');
    }
}
