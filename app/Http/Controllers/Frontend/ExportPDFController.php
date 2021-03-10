<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Experiment;
use App\Services\ExtendedMpdf;
use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;
use DOMDocument;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class ExportPDFController
{

    public function export(Request $request)
    {
        $params = $request->params;
        $imgResult = $request->imgResult;

        $experiment = Experiment::findOrFail($request->experiment_id);

        //$date = date('d.m.Y h:i:s a', time());
        $date = Carbon::now();

        $doc = new DOMDocument();
        $doc->loadHTML($experiment->description);

        $imgs = $doc->getElementsByTagName('img');
        $img = collect($imgs)->first();

        $mpdf = new ExtendedMpdf();
        $mpdf->showImageErrors = false;

        $mpdf->WriteHTML(view('frontend.export.fo', compact('experiment', 'params', 'imgResult', 'date', 'img')));
        $content = $mpdf->Output("", "S");
        return chunk_split(base64_encode($content));
    }

    public function exportComparisonPDF(Request $request)
    {

        $experiment = Experiment::findOrFail($request->experiment_id);

        $history = $request->history;
        $params = $request->params;
        $imgResult = $request->imgResult;
        $schemes = $request->schemes;
        $date = Carbon::now();

        $mpdf = new ExtendedMpdf();
        $mpdf->showImageErrors = false;
        $rowHeight = 5;
        $offset = 15;
        $secondPartHeight = 80;
        $mpdf->Image($imgResult, 55, $secondPartHeight + $offset + 15, 140, 0, 'png');

        $mpdf->WriteHTML(view('frontend.export.comparison', compact('experiment', 'history', 'params', 'imgResult', 'date', 'schemes')));
        $content = $mpdf->Output("", "S");
        return chunk_split(base64_encode($content));
    }
}
