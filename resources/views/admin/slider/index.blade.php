@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.slider.actions.index'))

@section('body')

    <slider-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/sliders') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.slider.actions.index') }}
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/sliders/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.slider.actions.create') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="">
                                <div class="row justify-content-md-baseline align-items-end">
                                    <div class="col col-lg-7 col-xl-4 form-group">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="{{ trans('brackets/admin-ui::admin.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary" @click="filter('search', search)"><i class="fa fa-search"></i>&nbsp; {{ trans('brackets/admin-ui::admin.btn.search') }}</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col col-12 col-xl-4 form-group">
                                        <label>{{ trans('admin.slider.filters.layout') }}</label>
                                        <multiselect v-model="layoutMultiselect"
                                             :options="{{ $layouts->toJson() }}"
                                             label="name"
                                             track-by="id"
                                             placeholder="{{ trans('admin.slider.filters.layout') }}"
                                             :multiple="true">
                                        </multiselect>
                                    </div>
                                    <div class="col col-12 col-xl-4 form-group">
                                        <label>{{ trans('admin.slider.filters.comparison') }}</label>
                                        <multiselect v-model="comparisonMultiselect"
                                             :options="{{ $comparisons->toJson() }}"
                                             label="title"
                                             track-by="id"
                                             placeholder="{{ trans('admin.slider.filters.comparison') }}"
                                             :multiple="true">
                                        </multiselect>
                                    </div>
                                    <div class="col-sm-auto form-group ">
                                        <select class="form-control" v-model="pagination.state.per_page">
                                            
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                </div>
                            </form>

                            <table class="table table-hover table-listing">
                                <thead>
                                    <tr>
                                        <th class="bulk-checkbox">
                                            <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled"  name="enabled_fake_element" @click="onBulkItemsClickedAllWithPagination()">
                                            <label class="form-check-label" for="enabled">
                                                #
                                            </label>
                                        </th>

                                        <th is='sortable' :column="'id'">{{ trans('admin.slider.columns.id') }}</th>
                                        <th is='sortable' :column="'title'">{{ trans('admin.slider.columns.title') }}</th>
                                        <th is='sortable' :column="'layout_id'">{{ trans('admin.slider.columns.layout_id') }}</th>
                                        <th is='sortable' :column="'min'">{{ trans('admin.slider.columns.min') }}</th>
                                        <th is='sortable' :column="'max'">{{ trans('admin.slider.columns.max') }}</th>
                                        <th is='sortable' :column="'default'">{{ trans('admin.slider.columns.default') }}</th>
                                        <th is='sortable' :column="'step'">{{ trans('admin.slider.columns.step') }}</th>
                                        <th is='sortable' :column="'step'">{{ trans('admin.slider.columns.sorting') }}</th>
                                       

                                        <th></th>
                                    </tr>
                                    <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                        <td class="bg-bulk-info d-table-cell text-center" colspan="9">
                                            <span class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}.  <a href="#" class="text-primary" @click="onBulkItemsClickedAll('/admin/sliders')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('brackets/admin-ui::admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a
                                                        href="#" class="text-primary" @click="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a>  </span>

                                            <span class="pull-right pr-2">
                                                <button class="btn btn-sm btn-danger pr-3 pl-3" @click="bulkDelete('/admin/sliders/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
                                            </span>

                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                        <td class="bulk-checkbox">
                                            <input class="form-check-input" :id="'enabled' + item.id" type="checkbox" v-model="bulkItems[item.id]" v-validate="''" :data-vv-name="'enabled' + item.id"  :name="'enabled' + item.id + '_fake_element'" @click="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">
                                            <label class="form-check-label" :for="'enabled' + item.id">
                                            </label>
                                        </td>
                                        <td>@{{ item.id }}</td>
                                        <td>@{{ item.title }}</td>
                                        <td>@{{ item.layoutTitle }}</td>
                                        <td>@{{ item.min }}</td>
                                        <td>@{{ item.max }}</td>
                                        <td>@{{ (item.default != null) ? item.default : 'function' }}</td>
                                        <td>@{{ item.step }}</td>
                                        <td>@{{ item.sorting }}</td>
                                        
                                        <td>
                                            <div class="row no-gutters">
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-spinner btn-info" :href="item.resource_url + '/edit'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                </div>
                                                <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                                    <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row" v-if="pagination.state.total > 0">
                                <div class="col-sm">
                                    <span class="pagination-caption">{{ trans('brackets/admin-ui::admin.pagination.overview') }}</span>
                                </div>
                                <div class="col-sm-auto">
                                    <pagination></pagination>
                                </div>
                            </div>

                            <div class="no-items-found" v-if="!collection.length > 0">
                                <i class="icon-magnifier"></i>
                                <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                                <p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                                <a class="btn btn-primary btn-spinner" href="{{ url('admin/sliders/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.slider.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </slider-listing>

@endsection