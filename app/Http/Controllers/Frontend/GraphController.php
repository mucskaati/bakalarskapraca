<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Checkbox;
use App\Models\Experiment;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Database\Eloquent\Builder;

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

        return view('frontend.graphs.single', [
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

        return view('frontend.graphs.path_based', [
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
        $slidersAdditional = Slider::withCount('comparisonExperiments')->doesntHave('dependentCheckboxes')
            ->whereHas('comparisonExperiments', function (Builder $query) use ($experiment) {
                $query->whereIn('comparison_experiments.id', $experiment->schemes->pluck('id')->toArray());
            })->where('visible', 1)->orderBy('sorting')->get();
        $slidersAdditionalHasDependent = Slider::withCount('comparisonExperiments')->has('dependentCheckboxes')
            ->whereHas('comparisonExperiments', function (Builder $query) use ($experiment) {
                $query->whereIn('comparison_experiments.id', $experiment->schemes->pluck('id')->toArray());
            })->where('visible', 1)->orderBy('sorting')->get();

        $checkboxesAdditional = Checkbox::with('dependentSliders')->withCount('comparisonExperiments')
            ->whereHas('comparisonExperiments', function (Builder $query) use ($experiment) {
                $query->whereIn('comparison_experiments.id', $experiment->schemes->pluck('id')->toArray());
            })->get();

        $schemeSliders = collect([]);
        foreach ($experiment->schemes as $comparison) {
            foreach ($comparison->sliders()->withCount('comparisonExperiments')->where('default_function', null)->get() as $slider) {
                if ($slider->comparison_experiments_count == 1) {
                    $schemeSliders->push(['title' => $slider->title, 'min' => $slider->min, 'max' => $slider->max, 'default' => $slider->default, 'step' => $slider->step]);
                }
            }
            foreach ($comparison->sliders()->withCount('comparisonExperiments')->where('default_function', '!=', null)->get() as $slider) {
                if ($slider->comparison_experiments_count == 1) {
                    $schemeSliders->push(['title' => $slider->title, 'min' => $slider->min, 'max' => $slider->max, 'default' => $slider->default_function, 'step' => $slider->step]);
                }
            }
        }
        $schemeSliders = $schemeSliders->mapWithKeys(function ($item) {
            return [$item['title'] => $item];
        });

        $template = view(
            ['template' => $experiment->template],
            ['experiment' => $experiment, 'fos' => $fos, 'comparisons' => $compars, 'nyquist' => $nyquist, 'sliderSchemes' => $schemeSliders, 'slidersAdditional' => $slidersAdditional, 'checkboxesAdditional' => $checkboxesAdditional],
        );
        return view('frontend.graphs.comparison', [
            'experiment' => $experiment,
            'preset' => $template,
            'fos' => $fos,
            'comparisons' => $compars,
            'nyquist' => $nyquist,
            'sliderSchemes' => $schemeSliders,
            'slidersAdditional' => $slidersAdditional,
            'slidersAdditionalHasDependent' => $slidersAdditionalHasDependent,
            'checkboxesAdditional' => $checkboxesAdditional
        ]);
    }
}
