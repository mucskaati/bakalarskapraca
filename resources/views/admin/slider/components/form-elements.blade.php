<div class="row">
    <div class="col-md-12">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('type'), 'has-success': fields.type && fields.type.valid }">
            <label for="type" class="col-12 col-form-label text-md-left">{{ trans('admin.slider.columns.type') }}</label>
                <div class="col-md-6 text-center">
                <label for="type" class="col-form-label text-md-center">{{ trans('admin.slider.columns.experiment_fo') }}</label>
                    <div>
                        <input type="radio" v-model="form.type" value="fo">
                        <div v-if="errors.has('type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('type') }}</div>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <label for="type" class="col-form-label text-md-center">{{ trans('admin.slider.columns.scheme') }}</label>
                        <div>
                            <input type="radio" v-model="form.type" value="comparison">
                            <div v-if="errors.has('type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('type') }}</div>
                        </div>
                </div>
        </div>
    </div>
</div>
<div class="row" v-if="form.type !== null">
    <div class="col-12 offset-md-1 col-md-4">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('title'), 'has-success': fields.title && fields.title.valid }">
            <label for="title" class="col-form-label text-md-left col-md-12">{{ trans('admin.slider.columns.title') }}</label>
                <div :class="'col-md-12'">
                <input type="text" v-model="form.title"  @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('title'), 'form-control-success': fields.title && fields.title.valid}" id="title" name="title" placeholder="{{ trans('admin.slider.columns.title') }}">
                <div v-if="errors.has('title')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('title') }}</div>
            </div>
        </div>
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('label'), 'has-success': fields.label && fields.label.valid }">
            <label for="label" class="col-form-label text-md-left col-md-12">{{ trans('admin.slider.columns.label') }}</label>
                <div :class="'col-md-12'">
                <input type="text" v-model="form.label"  @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('label'), 'form-control-success': fields.label && fields.label.valid}" id="label" name="label" placeholder="{{ trans('admin.slider.columns.label') }}">
                <div v-if="errors.has('label')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('label') }}</div>
            </div>
        </div>
        <div v-if="form.type == 'fo'" class="form-group row align-items-center" :class="{'has-danger': errors.has('layout_id'), 'has-success': fields.layout_id && fields.layout_id.valid }">
            <label for="layout_id" class="col-12 col-form-label">{{ trans('admin.slider.columns.layout_id') }}</label>
                <div class="col-12">
                    <multiselect v-model="form.layout" :options="{{ $layouts->toJson() }}" placeholder="{{ trans('admin.slider.columns.layout_id') }}" label="name" track-by="id" :multiple="false">
                    </multiselect>
                <div v-if="errors.has('layout_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('layout_id') }}</div>
            </div>
        </div>
        <div v-if="form.type == 'comparison'" class="form-group row align-items-center" :class="{'has-danger': errors.has('comparison_experiment_id'), 'has-success': fields.comparison_experiment_id && fields.comparison_experiment_id.valid }">
            <label for="comparison_experiment_id" class="col-12 col-form-label">{{ trans('admin.slider.columns.comparison_experiment_id') }}</label>
                <div class="col-12">
                    <multiselect v-model="form.comparison_experiments" :taggable="true" :options="{{ $comparisonExperiments->toJson() }}" placeholder="{{ trans('admin.slider.columns.comparison_experiment_id') }}" label="title" track-by="id" :multiple="true">
                    </multiselect>
                <div v-if="errors.has('comparison_experiment')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('comparison_experiment') }}</div>
            </div>
        </div>
        <div class="form-group row" :class="{'has-danger': errors.has('visible'), 'has-success': fields.visible && fields.visible.valid }">
            <div  class="col-6 mt-5">
                <input class="form-check-input" :id="'visible'" type="checkbox" v-model="form.visible" v-validate="''" data-vv-name="visible"  name="visible_fake_element">
                <label class="form-check-label" :for="'visible'">
                    {{ trans('admin.slider.columns.visible') }}
                </label>
                <input type="hidden" :name="'visible'" :value="form.visible">
                <div v-if="errors.has('visible')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('visible') }}</div>
            </div>
        </div>
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('columns'), 'has-success': fields.columns && fields.columns.valid }">
            <label for="columns" class="col-form-label text-md-left col-md-12">{{ trans('admin.slider.columns.columns') }}</label>
                <div :class="'col-md-12'">
                <input type="text" v-model="form.columns"  @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('columns'), 'form-control-success': fields.columns && fields.columns.valid}" id="columns" name="columns" placeholder="{{ trans('admin.slider.columns.columns') }}">
                <small>{{ trans('admin.slider.columns.columns_desc') }}</small>
                <div v-if="errors.has('columns')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('columns') }}</div>
            </div>
        </div>
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('sorting'), 'has-success': fields.sorting && fields.sorting.valid }">
            <label for="sorting" class="col-form-label text-md-left col-md-12">{{ trans('admin.slider.columns.sorting') }}</label>
                <div :class="'col-md-12'">
                <input type="text" v-model="form.sorting"  @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('sorting'), 'form-control-success': fields.sorting && fields.sorting.valid}" id="sorting" name="sorting" placeholder="{{ trans('admin.slider.columns.sorting') }}">
                <small>{{ trans('admin.slider.columns.sorting_desc') }}</small>
                <div v-if="errors.has('sorting')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('sorting') }}</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('min'), 'has-success': fields.min && fields.min.valid }">
            <label for="min" class="col-form-label text-md-left col-md-12">{{ trans('admin.slider.columns.min') }}</label>
                <div :class="'col-md-12'">
                <input type="number" v-model="form.min"  @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('min'), 'form-control-success': fields.min && fields.min.valid}" id="min" name="min" placeholder="{{ trans('admin.slider.columns.min') }}">
                <div v-if="errors.has('min')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('min') }}</div>
            </div>
        </div>

        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('max'), 'has-success': fields.max && fields.max.valid }">
            <label for="max" class="col-form-label text-md-left col-md-12">{{ trans('admin.slider.columns.max') }}</label>
                <div :class="'col-md-12'">
                <input type="number" v-model="form.max"  @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('max'), 'form-control-success': fields.max && fields.max.valid}" id="max" name="max" placeholder="{{ trans('admin.slider.columns.max') }}">
                <div v-if="errors.has('max')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('max') }}</div>
            </div>
        </div>
        <div class="form-group row align-items-baseline" :class="{'has-danger': errors.has('default'), 'has-success': fields.default && fields.default.valid }">
            <div class="col-md-4">
                <div class="form-group row align-baseline" :class="{'has-danger': errors.has('default'), 'has-success': fields.default && fields.default.valid }">
                    <label for="default" class="col-form-label text-md-left col-md-12">{{ trans('admin.slider.columns.default') }}</label>
                        <div :class="'col-md-12'">
                        <input type="number" v-model="form.default"  @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('default'), 'form-control-success': fields.default && fields.default.valid}" id="default" name="default" placeholder="{{ trans('admin.slider.columns.default') }}">
                        <div v-if="errors.has('default')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('default') }}</div>
                    </div>
                </div>
            </div>
           <div class="col-md-8">
            <div class="form-group row align-items-baseline" :class="{'has-danger': errors.has('default_function'), 'has-success': fields.default_function && fields.default_function.valid }">
                <label for="default_function" class="col-form-label text-md-left col-md-12">{{ trans('admin.slider.columns.default_function') }}</label>
                <div :class="'col-md-12'">
                    <div>
                        <textarea class="form-control" v-model="form.default_function" v-validate="''" id="default_function" name="default_function"></textarea>
                    </div>
                    <div v-if="errors.has('default_function')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('default_function') }}</div>
                </div>
            </div>
           </div>
        </div>
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('step'), 'has-success': fields.step && fields.step.valid }">
            <label for="step" class="col-form-label text-md-left col-md-12">{{ trans('admin.slider.columns.step') }}</label>
                <div :class="'col-md-12'">
                <input type="number" v-model="form.step"  @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('step'), 'form-control-success': fields.step && fields.step.valid}" id="step" name="step" placeholder="{{ trans('admin.slider.columns.step') }}">
                <div v-if="errors.has('step')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('step') }}</div>
            </div>
        </div>
    </div>
</div>


