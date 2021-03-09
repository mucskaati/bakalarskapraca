<div class="form-group row align-items-center" :class="{'has-danger': errors.has('experiment_id'), 'has-success': fields.experiment_id && fields.experiment_id.valid }">
    <label for="title" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.example.columns.experiment_id') }}</label>
        <div class="col-8">
            <multiselect v-model="form.experiment" :options="{{ $experiments->toJson() }}" placeholder="{{ trans('admin.example.columns.experiment_id') }}" label="title" track-by="id" :multiple="false"></multiselect>
        <div v-if="errors.has('experiment_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('experiment_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('title'), 'has-success': fields.title && fields.title.valid }">
    <label for="title" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.example.columns.title') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.title" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('title'), 'form-control-success': fields.title && fields.title.valid}" id="title" name="title" placeholder="{{ trans('admin.example.columns.title') }}">
        <div v-if="errors.has('title')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('title') }}</div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-6 offset-1">
        <h4>{{ __('admin.example.columns.set_slider_in_example') }}</h4>
    </div>
</div>
<div v-for="(input, index) in form.sliders" :key="index">
    <hr>
<div class="row">
    <div class="col-12 offset-md-1 col-md-4 mt-1">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('slider'), 'has-success': fields.slider && fields.slider.valid }">
            <label for="slider" class="col-6 col-form-label">{{ trans('admin.example.columns.sliders') }}</label>
                <div class="col-12">
                    <multiselect v-model="form.sliders[index]"  @input="addCountSlider(index)" :options="{{ $sliders->map(function($item) { return  ['id' => $item->id, 'title' => $item->titleWithLayout]; })->toJson() }}" placeholder="{{ trans('admin.example.columns.sliders') }}" label="title" track-by="id" :multiple="false"></multiselect>
                <div v-if="errors.has('slider')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('slider') }}</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-group row align-items-baseline" :class="{'has-danger': errors.has('value'), 'has-success': fields.value && fields.value.valid }">
            <label for="value" class="col-form-label text-md-left col-md-12">{{ trans('admin.example.columns.value') }}</label>
            <div :class="'col-md-12'">
                <div>
                    <textarea class="form-control" v-model="form.sliders[index].pivot.value" v-validate="''" id="value" name="value"></textarea>
                </div>
                <div v-if="errors.has('value')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('value') }}</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3 align-items-center d-flex justify-content-center">
        <a v-on:click.stop="deleteSlider(index);" class="btn btn-danger" style="color: white">
            {{ trans('admin.example.columns.delete') }}
        </a>
    </div>
</div>
</div>

<div class="row">
    <div class="col-12 col-md-12 text-center mt-5">
        <a v-on:click.stop="addSlider" class="btn btn-primary" style="color: white">
            <i class="fa fa-plus"></i> {{ trans('admin.example.columns.add_slider') }}
        </a>
    </div>
</div>

<div class="row mt-5">
    <div class="col-6 offset-1">
        <h4>{{ __('admin.example.columns.set_checkbox_in_example') }}</h4>
    </div>
</div>
<div v-for="(input, index) in form.checkboxes" :key="index + 'A'">
    <hr>
<div class="row">
    <div class="col-12 offset-md-1 col-md-4 mt-1">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('checkbox'), 'has-success': fields.checkbox && fields.checkbox.valid }">
            <label for="checkbox" class="col-6 col-form-label">{{ trans('admin.example.columns.checkboxes') }}</label>
                <div class="col-12">
                    <multiselect v-model="form.checkboxes[index]"  @input="addCountCheckbox(index)" :options="{{ $checkboxes->map(function($item) { return  ['id' => $item->id, 'title' => $item->titleWithLayout]; })->toJson() }}" placeholder="{{ trans('admin.example.columns.checkboxes') }}" label="title" track-by="id" :multiple="false"></multiselect>
                <div v-if="errors.has('checkbox')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('checkbox') }}</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-group row align-items-baseline" :class="{'has-danger': errors.has('value'), 'has-success': fields.value && fields.value.valid }">
            <label for="value" class="col-form-label text-md-left col-md-12">{{ trans('admin.example.columns.checked') }}</label>
            <div :class="'col-md-12'">
                <input class="form-check-input" :id="'checked' + index" type="checkbox" v-model="form.checkboxes[index].pivot.checked" v-validate="''" data-vv-name="export"  name="export_fake_element">
                <label class="form-check-label" :for="'checked' + index">
                    {{ trans('admin.example.columns.checked') }}
                </label>
                <input type="hidden" :name="'checked' + index" :value="form.checkboxes[index].pivot.value">
                <div v-if="errors.has('checked' + index)" class="form-control-feedback form-text" v-cloak>@{{ errors.first('export') }}</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3 align-items-center d-flex justify-content-center">
        <a v-on:click.stop="deleteCheckbox(index);" class="btn btn-danger" style="color: white">
            {{ trans('admin.example.columns.delete') }}
        </a>
    </div>
</div>
</div>

<div class="row">
    <div class="col-12 col-md-12 text-center mt-5">
        <a v-on:click.stop="addCheckbox" class="btn btn-primary" style="color: white">
            <i class="fa fa-plus"></i> {{ trans('admin.example.columns.add_checkbox') }}
        </a>
    </div>
</div>

<div class="row mt-5">
    <div class="col-6 offset-1">
        <h4>{{ __('admin.example.columns.set_scheme_visibility_in_example') }}</h4>
    </div>
</div>
<div v-for="(input, index) in form.schemes" :key="index + 'b'">
    <hr>
<div class="row">
    <div class="col-12 offset-md-1 col-md-4 mt-1">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('checkbox'), 'has-success': fields.checkbox && fields.checkbox.valid }">
            <label for="checkbox" class="col-6 col-form-label">{{ trans('admin.example.columns.schemes') }}</label>
                <div class="col-12">
                    <multiselect v-model="form.schemes[index]"  @input="addCountScheme(index)" :options="{{ $schemes->map(function($item) { return  ['id' => $item->id, 'title' => $item->title]; })->toJson() }}" placeholder="{{ trans('admin.example.columns.schemes') }}" label="title" track-by="id" :multiple="false"></multiselect>
                <div v-if="errors.has('checkbox')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('checkbox') }}</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-group row align-items-baseline" :class="{'has-danger': errors.has('checked'), 'has-success': fields.checked && fields.checked.valid }">
            <label for="value" class="col-form-label text-md-left col-md-12">{{ trans('admin.example.columns.checked') }}</label>
            <div :class="'col-md-12'">
                <input class="form-check-input" :id="'checked_scheme' + index" type="checkbox" v-model="form.schemes[index].pivot.checked" v-validate="''" data-vv-name="export"  name="export_fake_element">
                <label class="form-check-label" :for="'checked_scheme' + index">
                    {{ trans('admin.example.columns.checked') }}
                </label>
                <input type="hidden" :name="'checked_scheme' + index" :value="form.schemes[index].pivot.checked">
                <div v-if="errors.has('checked_scheme' + index)" class="form-control-feedback form-text" v-cloak>@{{ errors.first('checked_scheme') }}</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3 align-items-center d-flex justify-content-center">
        <a v-on:click.stop="deleteScheme(index);" class="btn btn-danger" style="color: white">
            {{ trans('admin.example.columns.delete') }}
        </a>
    </div>
</div>
</div>

<div class="row">
    <div class="col-12 col-md-12 text-center mt-5">
        <a v-on:click.stop="addScheme" class="btn btn-primary" style="color: white">
            <i class="fa fa-plus"></i> {{ trans('admin.example.columns.add_scheme') }}
        </a>
    </div>
</div>



