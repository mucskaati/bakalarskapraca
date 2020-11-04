@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.layout.actions.edit', ['name' => $layout->name]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <layout-form
                :action="'{{ $layout->resource_url }}'"
                :data="{{ $layout->toJSON() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.layout.actions.edit', ['name' => $layout->name]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.layout.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                           
                           UPRAVIŤ LAYOUT GRAFU
                        </button>
                    </div>
                    
                </form>

        </layout-form>

        </div>
    
</div>

@endsection