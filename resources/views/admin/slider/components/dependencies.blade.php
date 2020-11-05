<div class="row mt-5">
    <div class="col-6 offset-1">
        <h2>Závislosti slajdrov na tomto slajdri</h2>
    </div>
</div>
<div v-for="(input, index) in form.dependencies" :key="index">
    <hr>
<div class="row">
    <div class="col-12 offset-md-1 col-md-4 mt-1">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('layout_id'), 'has-success': fields.layout_id && fields.layout_id.valid }">
            <label for="layout_id" class="col-6 col-form-label">{{ trans('admin.slider.columns.depended_slider_id') }}</label>
                <div class="col-12">
                    <multiselect v-model="form.dependencies[index].pivot.depended_layout_id" :options="{{ $layouts->toJson() }}" placeholder="{{ trans('admin.slider.columns.depended_slider_id') }}" label="name" track-by="id" :multiple="false"></multiselect>
                <div v-if="errors.has('layout_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('layout_id') }}</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-group row" :class="{'has-danger': errors.has('same_as_added_slider'), 'has-success': fields.same_as_added_slider && fields.same_as_added_slider.valid }">
            <div  class="col-6 mt-5">
                <input class="form-check-input" id="same_as_added_slider" type="checkbox" v-model="form.same_as_added_slider" v-validate="''" data-vv-name="same_as_added_slider"  name="same_as_added_slider_fake_element">
                <label class="form-check-label" for="same_as_added_slider">
                    {{ trans('admin.slider.columns.same_as_added_slider') }}
                </label>
                <input type="hidden" name="same_as_added_slider" :value="form.dependencies[index].pivot.same_as_added_slider">
                <div v-if="errors.has('same_as_added_slider')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('same_as_added_slider') }}</div>
            </div>
        </div>
        <div class="form-group row align-items-baseline" :class="{'has-danger': errors.has('value_function'), 'has-success': fields.value_function && fields.value_function.valid }">
            <label for="value_function" class="col-form-label text-md-left col-md-12">{{ trans('admin.slider.columns.value_function') }}</label>
            <div :class="'col-md-12'">
                <div>
                    <textarea class="form-control" v-model="form.dependencies[index].pivot.value_function" v-validate="''" id="value_function" name="value_function"></textarea>
                </div>
                <div v-if="errors.has('value_function')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('value_function') }}</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3 align-items-center d-flex justify-content-center">
        <a v-on:click.stop="deleteDependency(index);" class="btn btn-danger" style="color: white">
            {{ trans('admin.slider.columns.delete') }}
        </a>
    </div>
</div>
</div>

<div class="row">
    <div class="col-12 col-md-12 text-center mt-5">
        <a v-on:click.stop="addDependency" class="btn btn-primary" style="color: white">
            <i class="fa fa-plus"></i> {{ trans('admin.slider.columns.add_dependency') }}
        </a>
    </div>
</div>


