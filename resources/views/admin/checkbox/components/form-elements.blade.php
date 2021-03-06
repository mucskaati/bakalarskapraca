<div class="row">
    <div class="col-md-12">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('type'), 'has-success': fields.type && fields.type.valid }">
            <label for="type" class="col-12 col-form-label text-md-left">{{ trans('admin.checkbox.columns.type') }}</label>
                <div class="col-md-6 text-center">
                <label for="type" class="col-form-label text-md-center">{{ trans('admin.checkbox.columns.experiment_fo') }}</label>
                    <div>
                        <input type="radio" v-model="form.type" value="fo">
                        <div v-if="errors.has('type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('type') }}</div>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <label for="type" class="col-form-label text-md-center">{{ trans('admin.checkbox.columns.scheme') }}</label>
                        <div>
                            <input type="radio" v-model="form.type" value="comparison">
                            <div v-if="errors.has('type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('type') }}</div>
                        </div>
                </div>
        </div>
    </div>
</div>
<div v-if="form.type == 'fo'" class="form-group row align-items-center" :class="{'has-danger': errors.has('layout_id'), 'has-success': fields.layout_id && fields.layout_id.valid }">
    <label for="layout_id" class="col-2 col-form-label text-right">{{ trans('admin.slider.columns.layout_id') }}</label>
        <div class="col-8">
            <multiselect v-model="form.layout" :options="{{ $layouts->toJson() }}" placeholder="{{ trans('admin.slider.columns.layout_id') }}" label="name" track-by="id" :multiple="false"></multiselect>
        <div v-if="errors.has('layout_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('layout_id') }}</div>
    </div>
</div>
<div v-if="form.type == 'comparison'" class="form-group row align-items-center" :class="{'has-danger': errors.has('comparison_experiment_id'), 'has-success': fields.comparison_experiment_id && fields.comparison_experiment_id.valid }">
    <label for="comparison_experiment_id" class="col-2 col-form-label text-right">{{ trans('admin.slider.columns.comparison_experiment_id') }}</label>
        <div class="col-8">
            <multiselect v-model="form.comparison_experiment" :options="{{ $comparisonExperiments->toJson() }}" placeholder="{{ trans('admin.slider.columns.comparison_experiment_id') }}" label="title" track-by="id" :multiple="false"></multiselect>
        <div v-if="errors.has('comparison_experiment')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('comparison_experiment') }}</div>
    </div>
</div>
<div class="form-group row align-items-center" :class="{'has-danger': errors.has('title'), 'has-success': fields.title && fields.title.valid }">
    <label for="title" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.checkbox.columns.title') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.title" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('title'), 'form-control-success': fields.title && fields.title.valid}" id="title" name="title" placeholder="{{ trans('admin.checkbox.columns.title') }}">
        <div v-if="errors.has('title')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('title') }}</div>
    </div>
</div>
<div class="form-group row align-items-center" :class="{'has-danger': errors.has('attribute_name'), 'has-success': fields.attribute_name && fields.attribute_name.valid }">
    <label for="attribute_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.checkbox.columns.attribute_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.attribute_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('attribute_name'), 'form-control-success': fields.attribute_name && fields.attribute_name.valid}" id="attribute_name" name="attribute_name" placeholder="{{ trans('admin.checkbox.columns.attribute_name') }}">
        <div v-if="errors.has('attribute_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('attribute_name') }}</div>
    </div>
</div>
<div class="form-group row" :class="{'has-danger': errors.has('slider_dependency_change'), 'has-success': fields.slider_dependency_change && fields.slider_dependency_change.valid }">
    <div  class="col-6 offset-md-4 mt-5">
        <input class="form-check-input" :id="'slider_dependency_change'" type="checkbox" v-model="form.slider_dependency_change" v-validate="''" data-vv-name="slider_dependency_change"  name="slider_dependency_change_fake_element">
        <label class="form-check-label" :for="'slider_dependency_change'">
            {{ trans('admin.checkbox.columns.slider_dependency_change') }}
        </label>
        <input type="hidden" :name="'slider_dependency_change'" :value="form.slider_dependency_change">
        <div v-if="errors.has('slider_dependency_change')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('slider_dependency_change') }}</div>
    </div>
</div>

