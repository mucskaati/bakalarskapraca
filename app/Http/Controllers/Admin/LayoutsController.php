<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Layout\BulkDestroyLayout;
use App\Http\Requests\Admin\Layout\DestroyLayout;
use App\Http\Requests\Admin\Layout\IndexLayout;
use App\Http\Requests\Admin\Layout\StoreLayout;
use App\Http\Requests\Admin\Layout\UpdateLayout;
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

class LayoutsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexLayout $request
     * @return array|Factory|View
     */
    public function index(IndexLayout $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Layout::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['columns', 'height', 'id', 'margin', 'name', 'rows', 'type', 'width', 'xaxis', 'yaxis'],

            // set columns to searchIn
            ['id', 'margin', 'name', 'type', 'xaxis', 'yaxis']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.layout.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.layout.create');

        return view('admin.layout.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLayout $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreLayout $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Layout
        $layout = Layout::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/layouts'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/layouts');
    }

    /**
     * Display the specified resource.
     *
     * @param Layout $layout
     * @throws AuthorizationException
     * @return void
     */
    public function show(Layout $layout)
    {
        $this->authorize('admin.layout.show', $layout);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Layout $layout
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Layout $layout)
    {
        $this->authorize('admin.layout.edit', $layout);


        return view('admin.layout.edit', [
            'layout' => $layout,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLayout $request
     * @param Layout $layout
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateLayout $request, Layout $layout)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Layout
        $layout->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/layouts'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/layouts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyLayout $request
     * @param Layout $layout
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyLayout $request, Layout $layout)
    {
        $layout->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyLayout $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyLayout $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Layout::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
