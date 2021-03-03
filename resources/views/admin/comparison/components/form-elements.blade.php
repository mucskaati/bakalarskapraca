@include('admin.comparison.components.step1')
<div class="row">
    <div class="col-12 col-md-12 text-center">
        <h5>{{ __('admin.experiment.steps.third') }}</h5>
    </div>
</div>
<div class="row mb-5">
    <loading :active.sync="isLoading" 
        :is-full-page="true"></loading>
    <div class="col-12 offset-md-1 col-md-5">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('title'), 'has-success': fields.title && fields.title.valid }">
            <label for="title" class="col-form-label" :class="isFormLocalized ? 'col-md-12' : 'col-md-12'">{{ trans('admin.comparison.columns.title') }}</label>
                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-12'">
                <input type="text" v-model="form.title" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('title'), 'form-control-success': fields.title && fields.title.valid}" id="title" name="title" placeholder="{{ trans('admin.comparison.columns.title') }}">
                <div v-if="errors.has('title')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('title') }}</div>
            </div>
        </div>
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('slug'), 'has-success': fields.slug && fields.slug.valid }">
            <label for="slug" class="col-form-label" :class="isFormLocalized ? 'col-md-12' : 'col-md-12'">{{ trans('admin.comparison.columns.slug') }}</label>
                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-12'">
                <input type="text" v-model="form.slug" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('slug'), 'form-control-success': fields.slug && fields.slug.valid}" id="slug" name="slug" placeholder="{{ trans('admin.comparison.columns.slug') }}">
                <div v-if="errors.has('slug')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('slug') }}</div>
            </div>
        </div>
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('layout_id'), 'has-success': fields.layout_id && fields.layout_id.valid }">
            <label for="layout_id" class="col-12 col-form-label">{{ trans('admin.comparison.columns.layout_id') }}</label>
                <div class="col-12">
                    <multiselect v-model="form.layout" :options="{{ $layouts->toJson() }}" placeholder="{{ trans('admin.comparison.columns.layout_id') }}" label="name" @input="getCountOfGraphs" track-by="id" :multiple="false"></multiselect>
                <div v-if="errors.has('layout_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('layout_id') }}</div>
            </div>
        </div>
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('ajax_url'), 'has-success': fields.ajax_url && fields.ajax_url.valid }">
            <label for="ajax_url" class="col-form-label" :class="isFormLocalized ? 'col-md-4' : 'col-md-12'">{{ trans('admin.comparison.columns.ajax_url') }}</label>
                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-12 col-xl-12'">
                <input type="text" v-model="form.ajax_url" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('ajax_url'), 'form-control-success': fields.ajax_url && fields.ajax_url.valid}" id="ajax_url" name="ajax_url" placeholder="{{ trans('admin.comparison.columns.ajax_url') }}">
                <div v-if="errors.has('ajax_url')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('ajax_url') }}</div>
            </div>
        </div>
        <div class="form-check row" :class="{'has-danger': errors.has('export'), 'has-success': fields.export && fields.export.valid }">
            <div  :class="isFormLocalized ? 'col-md-12' : 'col-md-12'">
                <input class="form-check-input" id="export" type="checkbox" v-model="form.export" v-validate="''" data-vv-name="export"  name="export_fake_element">
                <label class="form-check-label" for="export">
                    {{ trans('admin.comparison.columns.export') }}
                </label>
                <input type="hidden" name="export" :value="form.export">
                <div v-if="errors.has('export')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('export') }}</div>
            </div>
        </div>
        <div class="form-check row" :class="{'has-danger': errors.has('run_button'), 'has-success': fields.run_button && fields.run_button.valid }">
            <div  :class="isFormLocalized ? 'col-md-12' : 'col-md-12'">
                <input class="form-check-input" id="run_button" type="checkbox" v-model="form.run_button" v-validate="''" data-vv-name="run_button"  name="run_button_fake_element">
                <label class="form-check-label" for="run_button">
                    {{ trans('admin.comparison.columns.run_button') }}
                </label>
                <input type="hidden" name="run_button" :value="form.run_button">
                <div v-if="errors.has('run_button')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('run_button') }}</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-5">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('description'), 'has-success': fields.description && fields.description.valid }">
            <label for="description" class="col-form-label" :class="isFormLocalized ? 'col-md-4' : 'col-md-12'">{{ trans('admin.comparison.columns.description') }}</label>
                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-12 col-xl-12'">
                <div>
                    <wysiwyg v-model="form.description" v-validate="'required'" id="description" name="description" :config="mediaWysiwygConfig"></wysiwyg>
                </div>
                <div v-if="errors.has('description')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('description') }}</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-12 text-center d-flex justify-content-center" v-if="form.layout && form.ajax_url">
        <button type="submit" @click.prevent="getResponsesFromServer" class="btn btn-primary d-flex text-uppercase">{{ __('admin.experiment.steps.go_to_fourth') }}</button>
    </div>
</div>
@include('admin.comparison.components.schemes')
@include('admin.comparison.components.step5')

