<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Experiment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;

class GraphController extends Controller
{
    public function graph1($id, $slug)
    {
        $experiment = Experiment::with(['graphs', 'layout'])->where('id', $id)->where('slug', $slug)->firstOrFail();
        $fos = Experiment::where('type', 'fo')->orWhere('type', null)->get();
        $compars = Experiment::where('type', 'comparison')->get();
        $nyquist = Experiment::where('type', 'nyquist')->get();

        $template = view(
            ['template' => $experiment->template],
            ['experiment' => $experiment, 'fos' => $fos, 'comparisons' => $compars, 'nyquist' => $nyquist],
        );

        return view('frontend.graphs.graph1', [
            'experiment' => $experiment,
            'preset' => $template,
            'fos' => $fos,
            'comparisons' => $compars,
            'nyquist' => $nyquist
        ]);
    }

    public function graphNyquist($id, $slug)
    {
        $experiment = Experiment::with(['paths', 'layout'])->where('id', $id)->where('slug', $slug)->firstOrFail();
        $fos = Experiment::where('type', 'fo')->orWhere('type', null)->get();
        $comparisons = Experiment::where('type', 'comparison')->get();
        $nyquist = Experiment::where('type', 'nyquist')->get();

        $template = view(
            ['template' => $experiment->template],
            ['experiment' => $experiment, 'fos' => $fos, 'comparisons' => $comparisons, 'nyquist' => $nyquist],
        );

        return view('frontend.graphs.nyquist', [
            'experiment' => $experiment,
            'preset' => $template,
            'fos' => $fos,
            'comparisons' => $comparisons,
            'nyquist' => $nyquist
        ]);
    }

    public function comparison($id, $slug)
    {
        $experiment = Experiment::with(['graphs', 'layout', 'schemes'])->where('id', $id)->where('slug', $slug)->firstOrFail();
        $fos = Experiment::where('type', 'fo')->orWhere('type', null)->get();
        $compars = Experiment::where('type', 'comparison')->get();
        $nyquist = Experiment::where('type', 'nyquist')->get();

        $template = view(
            ['template' => $experiment->template],
            ['experiment' => $experiment, 'fos' => $fos, 'comparisons' => $compars, 'nyquist' => $nyquist],
        );
        return view('frontend.graphs.comparison', [
            'experiment' => $experiment,
            'preset' => $template,
            'fos' => $fos,
            'comparisons' => $compars,
            'nyquist' => $nyquist
        ]);
    }
}
