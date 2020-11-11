@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.checkbox.actions.edit', ['name' => $checkbox->title]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <checkbox-form
                :action="'{{ $checkbox->resource_url }}'"
                :data="{{ $checkbox->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.checkbox.actions.edit', ['name' => $checkbox->title]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.checkbox.components.form-elements')
                        @include('admin.checkbox.components.dependencies')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </checkbox-form>

        </div>
    
</div>

@endsection