<?php

namespace App\Http\Controllers\Frontend;

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;

class ExportPDFController
{

    public function export(Request $request)
    {
        //https://stackoverflow.com/questions/18484632/print-base64-coded-image-into-a-fpdf-document
        $img = explode(',', $request->imgResult);
        $imgResult = 'data://text/plain;base64,' . $img[1];


        //$date = date('d.m.Y h:i:s a', time());
        $date = date("d.m.Y h:i:s a", strtotime('+2 hours'));

        //var_dump($imgResult);
        //moznost pisanie indexov: http://www.fpdf.org/en/script/script61.php

        $rowHeight = 5;
        $secondPartHeight = 80;
        $offset = 15;
        $pdf = new Fpdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 30);
        $pdf->Cell(40, 10, 'Report - ' . $date);
        $pdf->Ln(12);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(40, 10, 'Schema');
        $pdf->Image(asset('img/symetry2020_s_FO.png'), 30, 35, 80);
        $pdf->Ln($secondPartHeight);
        $pdf->Cell(40, 10, 'Results');
        $pdf->Ln($offset);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(20, $rowHeight, "w = " . $request->parv_w);
        $pdf->Ln();
        $pdf->Cell(20, $rowHeight, "Ks = " . $request->parv_Ks);
        $pdf->Cell(20, $rowHeight, "Km = " . $request->parv_Ksm);
        $pdf->Ln();
        $pdf->Cell(20, $rowHeight, "a = " . $request->parv_a);
        $pdf->Cell(20, $rowHeight, "am = " . $request->parv_am);
        $pdf->Ln();
        $pdf->Cell(20, $rowHeight, "KP = " . $request->parv_KP);
        $pdf->Ln();
        $pdf->Cell(20, $rowHeight, "Tc = " . $request->parv_Tc);
        $pdf->Ln();
        $pdf->Cell(20, $rowHeight, "Umin = " . $request->parv_Umin);
        $pdf->Cell(20, $rowHeight, "Umax = " . $request->parv_Umax);
        //$pdf->Write(5,$_POST['imgResult']);
        $pdf->Image($imgResult, 55, $secondPartHeight + $offset + 15, 140, 0, 'png');
        $content = $pdf->Output("", "S");
        return chunk_split(base64_encode($content));
    }
}
