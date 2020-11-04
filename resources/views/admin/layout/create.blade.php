@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.layout.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">
        
        <layout-form
            :action="'{{ url('admin/layouts') }}'"
            :send-empty-locales="false"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                
                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.layout.actions.create') }}
                </div>

                <div class="card-body">
                    @include('admin.layout.components.form-elements')
                </div>
                                
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                       
                       VYTVORIŤ LAYOUT GRAFU
                    </button>
                </div>
                
            </form>

        </layout-form>

        </div>

        </div>

    
@endsection