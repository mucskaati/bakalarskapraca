<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Example\BulkDestroyExample;
use App\Http\Requests\Admin\Example\DestroyExample;
use App\Http\Requests\Admin\Example\IndexExample;
use App\Http\Requests\Admin\Example\StoreExample;
use App\Http\Requests\Admin\Example\UpdateExample;
use App\Models\Checkbox;
use App\Models\Example;
use App\Models\Experiment;
use App\Models\Slider;
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

class ExamplesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexExample $request
     * @return array|Factory|View
     */
    public function index(IndexExample $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Example::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'experiment_id', 'title'],

            // set columns to searchIn
            ['id', 'title']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.example.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.example.create');
        $sliders = Slider::all();
        $checkboxes = Checkbox::all();
        $experiments = Experiment::where('type', 'comparison')->get();

        return view('admin.example.create', [
            'sliders' => $sliders,
            'checkboxes' => $checkboxes,
            'experiments' => $experiments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreExample $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreExample $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Example
        $example = Example::create($sanitized);

        $this->syncDependencies($sanitized, $example);

        if ($request->ajax()) {
            return ['redirect' => url('admin/examples'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/examples');
    }

    /**
     * Display the specified resource.
     *
     * @param Example $example
     * @throws AuthorizationException
     * @return void
     */
    public function show(Example $example)
    {
        $this->authorize('admin.example.show', $example);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Example $example
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Example $example)
    {
        $this->authorize('admin.example.edit', $example);

        $example->load(['sliders', 'checkboxes', 'experiment']);

        $sliders = Slider::all();
        $checkboxes = Checkbox::all();
        $experiments = Experiment::where('type', 'comparison')->get();

        return view('admin.example.edit', [
            'example' => $example,
            'sliders' => $sliders,
            'checkboxes' => $checkboxes,
            'experiments' => $experiments
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateExample $request
     * @param Example $example
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateExample $request, Example $example)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Example
        $example->update($sanitized);

        $this->syncDependencies($sanitized, $example, 'update');


        if ($request->ajax()) {
            return [
                'redirect' => url('admin/examples'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/examples');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyExample $request
     * @param Example $example
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyExample $request, Example $example)
    {
        $example->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyExample $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyExample $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Example::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    private function syncDependencies($data, $model, $mode = 'create')
    {
        $sliders = collect($data['sliders'])->mapWithKeys(function ($item) {
            return [
                $item['id'] => [
                    'value' => $item['pivot']['value'],
                ],
            ];
        })->toArray();

        $checkboxes = collect($data['checkboxes'])->map(function ($item) {
            return $item['id'];
        })->toArray();

        //Syn dependencies to model
        if (count($data) > 0 || $mode == 'update') {
            $model->sliders()->sync($sliders);
        }

        if (count($data) > 0 || $mode == 'update') {
            $model->checkboxes()->sync($checkboxes);
        }

        return true;
    }
}
