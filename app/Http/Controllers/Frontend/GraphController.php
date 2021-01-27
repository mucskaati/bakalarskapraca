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

        $template = view(['template' => $experiment->template], ['experiment' => $experiment]);

        return view('frontend.graphs.graph1', [
            'experiment' => $experiment,
            'preset' => $template
        ]);
    }
}
