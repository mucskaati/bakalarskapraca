<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Experiment\BulkDestroyExperiment;
use App\Http\Requests\Admin\Experiment\DestroyExperiment;
use App\Http\Requests\Admin\Experiment\IndexExperiment;
use App\Http\Requests\Admin\Experiment\StoreExperiment;
use App\Http\Requests\Admin\Experiment\UpdateExperiment;
use App\Models\Experiment;
use App\Models\Graph;
use App\Models\Layout;
use App\Models\Trace;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ExperimentsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexExperiment $request
     * @return array|Factory|View
     */
    public function index(IndexExperiment $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Experiment::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['ajax_url', 'export', 'id', 'layout_id', 'title'],

            // set columns to searchIn
            ['ajax_url', 'description', 'id', 'title']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.experiment.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.experiment.create');

        $layouts = Layout::all();

        return view('admin.experiment.create', [
            'layouts' => $layouts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreExperiment $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreExperiment $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();


        // Store the Experiment
        $experiment = Experiment::create($sanitized);

        //Sync graphs and traces
        $this->createGraphsAndTraces($sanitized, $experiment);

        if ($request->ajax()) {
            return ['redirect' => url('admin/experiments'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/experiments');
    }

    /**
     * Display the specified resource.
     *
     * @param Experiment $experiment
     * @throws AuthorizationException
     * @return void
     */
    public function show(Experiment $experiment)
    {
        $this->authorize('admin.experiment.show', $experiment);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Experiment $experiment
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Experiment $experiment)
    {
        $this->authorize('admin.experiment.edit', $experiment);

        $layouts = Layout::all();

        $experiment->load(['graphs', 'layout']);

        return view('admin.experiment.edit', [
            'experiment' => $experiment,
            'layouts' => $layouts
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateExperiment $request
     * @param Experiment $experiment
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateExperiment $request, Experiment $experiment)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Experiment
        $experiment->update($sanitized);

        $this->createGraphsAndTraces($sanitized, $experiment);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/experiments'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/experiments');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyExperiment $request
     * @param Experiment $experiment
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyExperiment $request, Experiment $experiment)
    {
        $experiment->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyExperiment $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyExperiment $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Experiment::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    private function createGraphsAndTraces($data, $model)
    {
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

            foreach ($graph['traces'] as $trace) {
                $trace = Trace::create([
                    'title' => $trace['title'],
                    'graph_id' => $graphCreate->id,
                    'color' => $trace['color'],
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
