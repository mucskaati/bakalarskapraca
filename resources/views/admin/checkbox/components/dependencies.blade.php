<div class="row mt-5">
    <div class="col-6 offset-1">
        <h2>{{ trans('admin.checkbox.columns.checkbox_checked') }}</h2>
    </div>
</div>
<div v-for="(input, index) in form.dependent_sliders" :key="index">
    <hr>
<div class="row">
    <div class="col-12 offset-md-1 col-md-4 mt-1">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('layout_id'), 'has-success': fields.layout_id && fields.layout_id.valid }">
            <label for="layout_id" class="col-6 col-form-label">{{ trans('admin.checkbox.columns.slider_id') }}</label>
                <div class="col-12">
                    <multiselect v-model="form.dependent_sliders[index]"  @input="addCountDependency(index);" :options="filteredSliders" label="titleWithLayout" track-by="id" :multiple="false"></multiselect>
                <div v-if="errors.has('layout_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('layout_id') }}</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-group row align-items-baseline" :class="{'has-danger': errors.has('value_function'), 'has-success': fields.value_function && fields.value_function.valid }">
            <label for="value_function" class="col-form-label text-md-left col-md-12">{{ trans('admin.checkbox.columns.value_function') }}</label>
            <div :class="'col-md-12'">
                <div>
                    <textarea class="form-control" v-model="form.dependent_sliders[index].pivot.value_function" v-validate="'required'" id="value_function" name="value_function"></textarea>
                </div>
                <div v-if="errors.has('value_function')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('value_function') }}</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3 align-items-center d-flex justify-content-center">
        <a v-on:click.stop="deleteDependency(index);" class="btn btn-danger" style="color: white">
            {{ trans('admin.checkbox.columns.delete') }}
        </a>
    </div>
</div>
</div>

<div class="row">
    <div class="col-12 col-md-12 text-center mt-5">
        <a v-on:click.stop="addDependency" class="btn btn-primary" style="color: white">
            <i class="fa fa-plus"></i> {{ trans('admin.checkbox.columns.add_dependency') }}
        </a>
    </div>
</div>


