<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Traits\GraphableTraceableTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Comparison\BulkDestroyComparison;
use App\Http\Requests\Admin\Comparison\DestroyComparison;
use App\Http\Requests\Admin\Comparison\IndexComparison;
use App\Http\Requests\Admin\Comparison\StoreComparison;
use App\Http\Requests\Admin\Comparison\UpdateComparison;
use App\Http\Requests\Admin\Experiment\BulkDestroyExperiment;
use App\Http\Requests\Admin\Experiment\DestroyExperiment;
use App\Http\Requests\Admin\Experiment\IndexExperiment;
use App\Http\Requests\Admin\Experiment\StoreExperiment;
use App\Http\Requests\Admin\Experiment\UpdateExperiment;
use App\Models\Comparison;
use App\Models\ComparisonExperiment;
use App\Models\Experiment;
use App\Models\Layout;
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

class ComparisonsController extends Controller
{
    use GraphableTraceableTrait;

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
            ['id', 'title', 'ajax_url', 'export', 'layout_id', 'slug'],

            // set columns to searchIn
            ['id', 'title', 'slug', 'description', 'ajax_url'],

            function ($query) {
                $query->where('type', 'comparison');
            }
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.comparison.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.comparison.create');
        $layouts = Layout::all();
        $comparisonExperiments = ComparisonExperiment::all();


        return view('admin.comparison.create', [
            'layouts' => $layouts,
            'comparisonExperiments' => $comparisonExperiments
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

        // Store the Comparison
        $comparison = Experiment::create($sanitized);

        // Sync schemes
        $this->syncSchemes($sanitized, $comparison);

        // Sync graphs and traces
        $this->createGraphsAndTraces($sanitized, $comparison);

        if ($request->ajax()) {
            return ['redirect' => url('admin/comparisons'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/comparisons');
    }

    /**
     * Display the specified resource.
     *
     * @param Experiment $comparison
     * @throws AuthorizationException
     * @return void
     */
    public function show(Experiment $comparison)
    {
        $this->authorize('admin.comparison.show', $comparison);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Comparison $comparison
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Experiment $comparison)
    {
        $this->authorize('admin.comparison.edit', $comparison);
        $comparisonExperiments = ComparisonExperiment::all();
        $layouts = Layout::all();

        $comparison->load(['graphs', 'layout', 'schemes']);

        return view('admin.comparison.edit', [
            'comparison' => $comparison,
            'comparisonExperiments' => $comparisonExperiments,
            'layouts' => $layouts
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateExperiment $request
     * @param Comparison $comparison
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateExperiment $request, Experiment $comparison)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Comparison
        $comparison->update($sanitized);

        // Sync schemes
        $this->syncSchemes($sanitized, $comparison);

        // Sync graphs and traces
        $this->createGraphsAndTraces($sanitized, $comparison);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/comparisons'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/comparisons');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyExperiment $request
     * @param Comparison $comparison
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyExperiment $request, Experiment $comparison)
    {
        $comparison->delete();

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

    private function syncSchemes($data, $model)
    {
        $collection = collect($data['schemes'])->pluck('id')->toArray();
        $model->schemes()->sync($collection);

        return true;
    }
}
