@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.comparison-experiment.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">
        
        <comparison-experiment-form
            :action="'{{ url('admin/comparison-experiments') }}'"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                
                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.comparison-experiment.actions.create') }}
                </div>

                <div class="card-body">
                    @include('brackets/admin-ui::admin.includes.media-uploader', [
                        'mediaCollection' => app(App\Models\ComparisonExperiment::class)->getMediaCollection('schema'),
                        'label' => __('admin.comparison-experiment.columns.schema')
                    ])
                    @include('admin.comparison-experiment.components.form-elements')
                </div>
                                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>
                </div>
                
            </form>

        </comparison-experiment-form>

        </div>

        </div>

    
@endsection