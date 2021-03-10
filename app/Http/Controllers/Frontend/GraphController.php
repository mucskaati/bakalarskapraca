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

        $template = view(
            ['template' => $experiment->template],
            ['experiment' => $experiment, 'fos' => $fos, 'compars' => $compars],
        );

        return view('frontend.graphs.graph1', [
            'experiment' => $experiment,
            'preset' => $template,
            'fos' => $fos,
            'compars' => $compars
        ]);
    }

    public function comparison($id, $slug)
    {
        $experiment = Experiment::with(['graphs', 'layout', 'schemes'])->where('id', $id)->where('slug', $slug)->firstOrFail();
        $fos = Experiment::where('type', 'fo')->orWhere('type', null)->get();
        $compars = Experiment::where('type', 'comparison')->get();

        $template = view(
            ['template' => $experiment->template],
            ['experiment' => $experiment, 'fos' => $fos, 'compars' => $compars],
        );
        return view('frontend.graphs.comparison', [
            'experiment' => $experiment,
            'preset' => $template,
            'fos' => $fos,
            'compars' => $compars
        ]);
    }
}
