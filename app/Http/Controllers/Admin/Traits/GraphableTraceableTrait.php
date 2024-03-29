<?php

namespace App\Http\Controllers\Admin\Traits;

use App\Models\Graph;
use App\Models\Trace;

trait GraphableTraceableTrait
{
    protected function createGraphsAndTraces($data, $model)
    {
        $colors = ['#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#9467bd', '#8c564b', '#e377c2', '#7f7f7f', '#bcbd22', '#17becf'];
        $model->graphs()->delete();

        foreach ($data['graphs'] as $graph) {
            $graphCreate = Graph::create([
                'experiment_id' => $model->id,
                'annotation_title' => $graph['annotation_title'],
                'align' => $graph['align'],
                'annotation_angle' => $graph['annotation_angle'],
                'xaxis' => $graph['xaxis'],
                'yaxis' => $graph['yaxis'],
            ]);

            foreach ($graph['traces'] as $key => $trace) {
                $trace = Trace::create([
                    'title' => $trace['title'],
                    'graph_id' => $graphCreate->id,
                    'color' => ($trace['color']) ?: $colors[$key],
                    'legendgroup' => $trace['legendgroup'],
                    'show_legend' => $trace['show_legend'],
                    'xaxis' => $trace['xaxis']['id'],
                    'yaxis' => $trace['yaxis']['id'],
                ]);
            }
        }

        return true;
    }
}
