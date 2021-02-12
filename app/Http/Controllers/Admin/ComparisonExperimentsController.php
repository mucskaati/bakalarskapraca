<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ComparisonExperiment\BulkDestroyComparisonExperiment;
use App\Http\Requests\Admin\ComparisonExperiment\DestroyComparisonExperiment;
use App\Http\Requests\Admin\ComparisonExperiment\IndexComparisonExperiment;
use App\Http\Requests\Admin\ComparisonExperiment\StoreComparisonExperiment;
use App\Http\Requests\Admin\ComparisonExperiment\UpdateComparisonExperiment;
use App\Models\ComparisonExperiment;
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

class ComparisonExperimentsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexComparisonExperiment $request
     * @return array|Factory|View
     */
    public function index(IndexComparisonExperiment $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(ComparisonExperiment::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'title', 'description', 'prefix', 'trace_color', 'legendgroup'],

            // set columns to searchIn
            ['id', 'title', 'description', 'prefix', 'trace_color', 'legendgroup']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.comparison-experiment.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.comparison-experiment.create');

        return view('admin.comparison-experiment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreComparisonExperiment $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreComparisonExperiment $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the ComparisonExperiment
        $comparisonExperiment = ComparisonExperiment::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/comparison-experiments'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/comparison-experiments');
    }

    /**
     * Display the specified resource.
     *
     * @param ComparisonExperiment $comparisonExperiment
     * @throws AuthorizationException
     * @return void
     */
    public function show(ComparisonExperiment $comparisonExperiment)
    {
        $this->authorize('admin.comparison-experiment.show', $comparisonExperiment);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ComparisonExperiment $comparisonExperiment
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(ComparisonExperiment $comparisonExperiment)
    {
        $this->authorize('admin.comparison-experiment.edit', $comparisonExperiment);

        return view('admin.comparison-experiment.edit', [
            'comparisonExperiment' => $comparisonExperiment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateComparisonExperiment $request
     * @param ComparisonExperiment $comparisonExperiment
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateComparisonExperiment $request, ComparisonExperiment $comparisonExperiment)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values ComparisonExperiment
        $comparisonExperiment->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/comparison-experiments'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/comparison-experiments');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyComparisonExperiment $request
     * @param ComparisonExperiment $comparisonExperiment
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyComparisonExperiment $request, ComparisonExperiment $comparisonExperiment)
    {
        $comparisonExperiment->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyComparisonExperiment $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyComparisonExperiment $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    ComparisonExperiment::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
