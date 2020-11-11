<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Checkbox\BulkDestroyCheckbox;
use App\Http\Requests\Admin\Checkbox\DestroyCheckbox;
use App\Http\Requests\Admin\Checkbox\IndexCheckbox;
use App\Http\Requests\Admin\Checkbox\StoreCheckbox;
use App\Http\Requests\Admin\Checkbox\UpdateCheckbox;
use App\Models\Checkbox;
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

class CheckboxesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexCheckbox $request
     * @return array|Factory|View
     */
    public function index(IndexCheckbox $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Checkbox::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['attribute_name', 'id', 'layout_id', 'title'],

            // set columns to searchIn
            ['attribute_name', 'id', 'title']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.checkbox.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.checkbox.create');

        $sliders = Slider::all();
        $layouts = Layout::all();

        return view('admin.checkbox.create', [
            'sliders' => $sliders,
            'layouts' => $layouts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCheckbox $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreCheckbox $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Checkbox
        $checkbox = Checkbox::create($sanitized);

        //Sync dependent sliders
        $this->syncDependentSliders($sanitized, $checkbox);

        if ($request->ajax()) {
            return ['redirect' => url('admin/checkboxes'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/checkboxes');
    }

    /**
     * Display the specified resource.
     *
     * @param Checkbox $checkbox
     * @throws AuthorizationException
     * @return void
     */
    public function show(Checkbox $checkbox)
    {
        $this->authorize('admin.checkbox.show', $checkbox);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Checkbox $checkbox
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Checkbox $checkbox)
    {
        $this->authorize('admin.checkbox.edit', $checkbox);

        $sliders = Slider::all();
        $layouts = Layout::all();

        $checkbox->load(['dependentSliders', 'layout']);

        return view('admin.checkbox.edit', [
            'checkbox' => $checkbox,
            'sliders' => $sliders,
            'layouts' => $layouts
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCheckbox $request
     * @param Checkbox $checkbox
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateCheckbox $request, Checkbox $checkbox)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Checkbox
        $checkbox->update($sanitized);

        //Sync dependent sliders
        $this->syncDependentSliders($sanitized, $checkbox, 'update');

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/checkboxes'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/checkboxes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyCheckbox $request
     * @param Checkbox $checkbox
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyCheckbox $request, Checkbox $checkbox)
    {
        $checkbox->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyCheckbox $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyCheckbox $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Checkbox::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    private function syncDependentSliders($data, $model, $mode = 'create')
    {
        $colelction = collect($data['dependent_sliders'])->mapWithKeys(function ($item) {
            return [
                $item['id'] => [
                    'value_function' => $item['pivot']['value_function'],
                ],
            ];
        })->toArray();

        //Syn dependencies to model
        if (count($data) > 0 || $mode == 'update') {
            $model->dependentSliders()->sync($colelction);
        }

        return true;
    }
}
