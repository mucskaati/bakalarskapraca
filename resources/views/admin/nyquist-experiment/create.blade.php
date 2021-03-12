@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.nyquist_experiment.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">
        
        <nyquist-experiment-form
            :action="'{{ url('admin/nyquist-experiments') }}'"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                
                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.nyquist_experiment.actions.create') }}
                </div>

                <div class="card-body">
                    @include('admin.nyquist-experiment.components.form-elements')
                </div>
                                
                <div class="card-footer text-center" v-if="show_third_step">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('admin.nyquist_experiment.add_experiment') }}
                    </button>
                </div>
                
            </form>

        </nyquist-experiment-form>

        </div>

        </div>

    
@endsection