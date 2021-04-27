<div v-if="show_third_step">
    <div class="row mt-5">
        <div class="col-12 col-md-12 text-center mb-3">
            <h5>{{ __('admin.experiment.steps.third') }}</h5>
        </div>
        <div class="col-12 text-center">
            <h3>{{ __('admin.nyquist_experiment.columns.paths') }}</h3>
        </div>
    </div>
    <div v-for="(input, index) in form.paths" :key="index">
        <hr>
    <div class="row align-items-center">
        <div class="col-12 col-md-3 mt-1">
            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('path1_name'), 'has-success': fields.path1_name && fields.path1_name.valid }">
                <label for="path1_name" class="col-form-label" :class="isFormLocalized ? 'col-md-12' : 'col-md-12'">{{ trans('admin.nyquist_experiment.columns.path1_name') }}</label>
                    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-12'">
                    <input type="text" v-model="form.paths[index].path1_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('path1_name'), 'form-control-success': fields.path1_name && fields.path1_name.valid}" id="path1_name" name="path1_name" placeholder="{{ trans('admin.nyquist_experiment.columns.path1_name') }}">
                    <div v-if="errors.has('path1_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('path1_name') }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 mt-1">
            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('path1'), 'has-success': fields.path1 && fields.path1.valid }">
                <label for="path1" class="col-6 col-form-label">{{ trans('admin.nyquist_experiment.columns.path1') }}</label>
                    <div class="col-12">
                        <multiselect v-model="form.paths[index].path1"  @input="addCountPath(index)" :options="responses" placeholder="{{ trans('admin.nyquist_experiment.columns.path1') }}" label="title" track-by="id" :multiple="false"></multiselect>
                    <div v-if="errors.has('path1')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('path1') }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 mt-1">
            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('legend_color'), 'has-success': fields.legend_color && fields.legend_color.valid }">
                <label for="legend_color" class="col-form-label" :class="isFormLocalized ? 'col-md-12' : 'col-md-12'">{{ trans('admin.nyquist_experiment.columns.legend_color') }}</label>
                    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-12'">
                    <input type="text" v-model="form.paths[index].legend_color" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('legend_color'), 'form-control-success': fields.legend_color && fields.legend_color.valid}" id="legend_color" name="legend_color" placeholder="{{ trans('admin.nyquist_experiment.columns.legend_color') }}">
                    <div v-if="errors.has('legend_color')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('legend_color') }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 align-items-center d-flex justify-content-center">
            <a v-on:click.stop="deletePath(index);" class="btn btn-danger" style="color: white">
                {{ trans('admin.nyquist_experiment.columns.delete_path') }}
            </a>
        </div>
        <div class="col-12 col-md-3 mt-1">
            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('path2_name'), 'has-success': fields.path2_name && fields.path2_name.valid }">
                <label for="path1_name" class="col-form-label" :class="isFormLocalized ? 'col-md-12' : 'col-md-12'">{{ trans('admin.nyquist_experiment.columns.path2_name') }}</label>
                    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-12'">
                    <input type="text" v-model="form.paths[index].path2_name" v-validate="" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('path2_name'), 'form-control-success': fields.path2_name && fields.path2_name.valid}" id="path2_name" name="path2_name" placeholder="{{ trans('admin.nyquist_experiment.columns.path2_name') }}">
                    <div v-if="errors.has('path2_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('path1_name') }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 mt-1">
            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('path2'), 'has-success': fields.path2 && fields.path2.valid }">
                <label for="path2" class="col-6 col-form-label">{{ trans('admin.nyquist_experiment.columns.path2') }}</label>
                    <div class="col-12">
                        <multiselect v-model="form.paths[index].path2"  @input="addCountScheme(index)" :options="responses" placeholder="{{ trans('admin.nyquist_experiment.columns.path2') }}" label="title" track-by="id" :multiple="false"></multiselect>
                    <div v-if="errors.has('path2')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('path2') }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 mt-1">
            <div class="form-check row" :class="{'has-danger': errors.has('show_legend'), 'has-success': fields.show_legend && fields.show_legend.valid }">
                <div  :class="isFormLocalized ? 'col-md-12' : 'col-md-12'">
                    <input class="form-check-input" :id="'show_legend' + index" type="checkbox" v-model="form.paths[index].show_legend" v-validate="''" data-vv-name="show_legend"  name="show_legend_fake_element">
                    <label class="form-check-label" :for="'show_legend' + index">
                        {{ trans('admin.nyquist_experiment.columns.show_legend') }}
                    </label>
                    <input type="hidden" name="show_legend" :value="form.show_legend">
                    <div v-if="errors.has('show_legend')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('show_legend') }}</div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-12 text-center mt-5">
            <a v-on:click.stop="addPath" class="btn btn-primary" style="color: white">
                <i class="fa fa-plus"></i> {{ trans('admin.nyquist_experiment.columns.add_path') }}
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-center mt-5">
            <hr>
            <a href="" @click.prevent="toggleTemplate" v-if="!showTemplate" class="col-md-3 btn btn-primary">Edit template</a>
            <a href="" @click.prevent="toggleTemplate" v-if="showTemplate" class="col-md-3 btn btn-primary">Hide template</a>
        </div>
    </div>
    <div class="row" v-if="showTemplate">
        <div class="col-12 col-md-12">
            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('template'), 'has-success': fields.template && fields.template.valid }">
                <label for="template" class="col-form-label" :class="isFormLocalized ? 'col-md-4' : 'col-md-3'">{{ trans('admin.experiment.columns.template') }}</label>
                    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-12 col-xl-12'">
                    <div>
                        <prism-editor class="my-editor" v-model="form.template" :highlight="highlighter" line-numbers></prism-editor>
                    </div>
                    <div v-if="errors.has('template')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('template') }}</div>
                    </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('custom_js'), 'has-success': fields.custom_js && fields.custom_js.valid }">
                <label for="custom_js" class="col-form-label" :class="isFormLocalized ? 'col-md-4' : 'col-md-12'">{{ trans('admin.experiment.columns.custom_js') }}</label>
                    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-12 col-xl-12'">
                    <div>
                        <prism-editor class="my-editor" v-model="form.custom_js" :highlight="highlighter" line-numbers></prism-editor>
                    </div>
                    <div v-if="errors.has('custom_js')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('custom_js') }}</div>
                </div>
            </div>
        </div>
    </div>
    </div>