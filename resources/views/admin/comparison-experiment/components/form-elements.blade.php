<div class="row align-items-baseline">
    <div class="col-md-6">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('title'), 'has-success': fields.title && fields.title.valid }">
            <label for="title" class="col-form-label" :class="isFormLocalized ? 'col-md-12' : 'col-md-12'">{{ trans('admin.comparison-experiment.columns.title') }}</label>
                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-12'">
                <input type="text" v-model="form.title" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('title'), 'form-control-success': fields.title && fields.title.valid}" id="title" name="title" placeholder="{{ trans('admin.comparison-experiment.columns.title') }}">
                <div v-if="errors.has('title')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('title') }}</div>
            </div>
        </div>
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('shortcut'), 'has-success': fields.shortcut && fields.shortcut.valid }">
            <label for="shortcut" class="col-form-label" :class="isFormLocalized ? 'col-md-4' : 'col-md-12'">{{ trans('admin.comparison-experiment.columns.shortcut') }}</label>
                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-12'">
                <input type="text" v-model="form.shortcut" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('shortcut'), 'form-control-success': fields.shortcut && fields.shortcut.valid}" id="shortcut" name="shortcut" placeholder="{{ trans('admin.comparison-experiment.columns.shortcut') }}">
                <div v-if="errors.has('shortcut')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('shortcut') }}</div>
            </div>
        </div>
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('prefix'), 'has-success': fields.prefix && fields.prefix.valid }">
            <label for="prefix" class="col-form-label" :class="isFormLocalized ? 'col-md-4' : 'col-md-12'">{{ trans('admin.comparison-experiment.columns.prefix') }}</label>
                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-12'">
                <input type="text" v-model="form.prefix" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('prefix'), 'form-control-success': fields.prefix && fields.prefix.valid}" id="prefix" name="prefix" placeholder="{{ trans('admin.comparison-experiment.columns.prefix') }}">
                <div v-if="errors.has('prefix')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('prefix') }}</div>
            </div>
        </div>
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('trace_color'), 'has-success': fields.trace_color && fields.trace_color.valid }">
            <label for="trace_color" class="col-form-label" :class="isFormLocalized ? 'col-md-4' : 'col-md-12'">{{ trans('admin.comparison-experiment.columns.trace_color') }}</label>
                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-12'">
                <input type="text" v-model="form.trace_color" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('trace_color'), 'form-control-success': fields.trace_color && fields.trace_color.valid}" id="trace_color" name="trace_color" placeholder="{{ trans('admin.comparison-experiment.columns.trace_color') }}">
                <div v-if="errors.has('trace_color')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('trace_color') }}</div>
            </div>
        </div>
        
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('legendgroup'), 'has-success': fields.legendgroup && fields.legendgroup.valid }">
            <label for="legendgroup" class="col-form-label" :class="isFormLocalized ? 'col-md-4' : 'col-md-12'">{{ trans('admin.comparison-experiment.columns.legendgroup') }}</label>
                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-12'">
                <input type="text" v-model="form.legendgroup" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('legendgroup'), 'form-control-success': fields.legendgroup && fields.legendgroup.valid}" id="legendgroup" name="legendgroup" placeholder="{{ trans('admin.comparison-experiment.columns.legendgroup') }}">
                <div v-if="errors.has('legendgroup')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('legendgroup') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('description'), 'has-success': fields.description && fields.description.valid }">
            <label for="description" class="col-form-label" :class="isFormLocalized ? 'col-md-4' : 'col-md-12'">{{ trans('admin.experiment.columns.description') }}</label>
                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-12 col-xl-12'">
                <div>
                    <wysiwyg v-model="form.description" v-validate="'required'" id="description" name="description" :config="mediaWysiwygConfig"></wysiwyg>
                </div>
                <div v-if="errors.has('description')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('description') }}</div>
            </div>
        </div>
    </div>
</div>



