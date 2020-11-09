<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Slider\BulkDestroySlider;
use App\Http\Requests\Admin\Slider\DestroySlider;
use App\Http\Requests\Admin\Slider\IndexSlider;
use App\Http\Requests\Admin\Slider\StoreSlider;
use App\Http\Requests\Admin\Slider\UpdateSlider;
use App\Models\Layout;
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

class SlidersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexSlider $request
     * @return array|Factory|View
     */
    public function index(IndexSlider $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Slider::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['default', 'id', 'layout_id', 'max', 'min', 'step', 'title'],

            // set columns to searchIn
            ['default_function', 'id', 'title']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.slider.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.slider.create');

        $layouts = Layout::all();
        $sliders = Slider::all();

        return view('admin.slider.create', [
            'layouts' => $layouts,
            'sliders' => $sliders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSlider $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreSlider $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitizedDependencies = $request->getDependencies();

        // Store the Slider
        $slider = Slider::create($sanitized);

        $this->syncDependencies($sanitizedDependencies, $slider);

        if ($request->ajax()) {
            return ['redirect' => url('admin/sliders'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/sliders');
    }

    /**
     * Display the specified resource.
     *
     * @param Slider $slider
     * @throws AuthorizationException
     * @return void
     */
    public function show(Slider $slider)
    {
        $this->authorize('admin.slider.show', $slider);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Slider $slider
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Slider $slider)
    {
        $this->authorize('admin.slider.edit', $slider);

        $layouts = Layout::all();
        $sliders = Slider::all();

        $slider->load('layout');
        $slider->load('dependencies');

        return view('admin.slider.edit', [
            'slider' => $slider,
            'layouts' => $layouts,
            'sliders' => $sliders
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSlider $request
     * @param Slider $slider
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateSlider $request, Slider $slider)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Slider
        $slider->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/sliders'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/sliders');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroySlider $request
     * @param Slider $slider
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroySlider $request, Slider $slider)
    {
        $slider->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroySlider $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroySlider $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Slider::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    private function syncDependencies($data, $model, $mode = 'create')
    {
        $colelction = collect($data['dependencies'])->mapWithKeys(function ($item) {
            return [
                $item['id'] => [
                    'value_same_as_added' => $item['pivot']['value_same_as_added'],
                    'value_function' => $item['pivot']['value_function'],
                ],
            ];
        })->toArray();

        //Syn dependencies to model
        if (count($data) > 0 || $mode == 'update') {
            $model->dependencies()->sync($colelction);
        }

        return true;
    }
}
