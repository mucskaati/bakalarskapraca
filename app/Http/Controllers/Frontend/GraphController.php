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

        $schemeSliders = collect([]);
        foreach ($experiment->schemes as $comparison) {
            foreach ($comparison->sliders->where('default_function', null) as $slider) {
                $schemeSliders->push(['title' => $slider->title, 'default' => $slider->default, 'step' => $slider->step]);
            }
            foreach ($comparison->sliders->where('default_function', '!=', null) as $slider) {
                $schemeSliders->push(['title' => $slider->title, 'default' => $slider->default_function, 'step' => $slider->step]);
            }
        }
        $schemeSliders = $schemeSliders->mapWithKeys(function ($item) {
            return [$item['title'] => $item];
        });

        $template = view(
            ['template' => $experiment->template],
            ['experiment' => $experiment, 'fos' => $fos, 'comparisons' => $compars, 'nyquist' => $nyquist, 'sliderSchemes' => $schemeSliders],
        );
        return view('frontend.graphs.comparison', [
            'experiment' => $experiment,
            'preset' => $template,
            'fos' => $fos,
            'comparisons' => $compars,
            'nyquist' => $nyquist,
            'sliderSchemes' => $schemeSliders
        ]);
    }
}
