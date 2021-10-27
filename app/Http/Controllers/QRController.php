<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRController extends Controller
{
    public function generate($id)
    {
        $data = Assignment::findOrFail($id);
        $qrcode = QrCode::size(400)->generate($data->name);
        return view('qrcode', compact('qrcode'));
    }
}
