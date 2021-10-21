<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Assignment;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PDFController extends Controller
{
    private $fpdf;
    public $x;

    public function __construct()
    {
    }

    public function createPDF($id)
    {
        $assignment = Assignment::where('id', $id)->first();
        // VALIDASI APAKAH ASSIGNMENT ADA
        if ($assignment === NULL) {
            return back()->with('message', 'assignment-not-found');
        }

        // INISIASI FPDF
        $this->fpdf = new Fpdf;
        $this->fpdf->AddPage("P", "A4"); // Potrait A4

        // SET HEADING
        $this->Header($assignment);

        // PRINT
        $file_name = $assignment->nspp . '_' . $assignment->type;
        $this->fpdf->Output('D', 'SPP_' . $file_name . '.pdf');
        exit;
    }

    public function Header($assignment)
    {
        // LOGO TVKU
        // $this->fpdf->Image("img/tvku_logo_ori.png", NULL, NULL, 30, 17); // SIZE 30 x 17 mm
        $height = 4;
        $this->floatingImage("img/tvku_logo_ori.png", $height); // SIZE 30 x 17 mm

        $date = Carbon::createFromFormat('Y-m-d', $assignment->created);
        $month = $date->month;
        $roman_month = $this->numberToRoman($month);
        $year = $date->year;

        // TULISAN PT. TVKU DAN ALAMAT
        $this->fpdf->SetFont('Times', 'BU', 14);
        // $this->fpdf->Cell(50, 10, '', 0, 0, 'C'); // DUMMY SUPAYA JUDUL CENTER
        // $this->fpdf->Cell(0, 20, 'PT. TELEVISI KAMPUS UNIVERSITAS DIAN NUSWANTORO', 0, 2, 'C');
        $this->fpdf->Write($height, "PT. TELEVISI KAMPUS UNIVERSITAS DIAN NUSWANTORO");
        $this->fpdf->SetFont('Times', '', 14);
        // $this->fpdf->Cell(0, 0, 'No. ' . $assignment->nspp . '/SPP-D/' . $roman_month . '/TVKU/' . $year, 0, 0, 'C');
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

    public function floatingImage($imgPath, $height)
    {
        list($w, $h) = getimagesize($imgPath);
        $ratio = $w / $h;
        $imgWidth = $height * $ratio;

        $this->fpdf->Image($imgPath, NULL, NULL, 30, 17);
        $this->x += $imgWidth;
    }
}
