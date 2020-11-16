@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.experiment.actions.edit', ['name' => $experiment->title]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <experiment-form
                :action="'{{ $experiment->resource_url }}'"
                :data="{{ $experiment->toJson() }}"
                :update="true"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.experiment.actions.edit', ['name' => $experiment->title]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.experiment.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer text-center" v-if="show_third_step">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('admin.experiment.edit_experiment') }}
                        </button>
                    </div>
                    
                </form>

        </experiment-form>

        </div>
    
</div>

@endsection