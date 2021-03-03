<div v-if="show_third_step">
<div class="row mt-5">
    <div class="col-12 col-md-12 text-center mb-3">
        <h5>{{ __('admin.experiment.steps.fourth') }}</h5>
    </div>
    <div class="col-12 text-center">
        <h3>{{ __('admin.comparison.columns.experiment_schemes') }}</h3>
    </div>
</div>
<div v-for="(input, index) in form.schemes" :key="index">
    <hr>
<div class="row">
    <div class="col-12 offset-md-1 col-md-6 mt-1">
        <div class="form-group row align-items-center" :class="{'has-danger': errors.has('schemes'), 'has-success': fields.schemes && fields.schemes.valid }">
            <label for="schemes" class="col-6 col-form-label">{{ trans('admin.comparison.columns.scheme') }}</label>
                <div class="col-12">
                    <multiselect v-model="form.schemes[index]"  @input="addCountScheme(index)" :options="{{ $comparisonExperiments
                    ->map(function($item) { return  ['id' => $item->id, 'title' => $item->titleAndPrefix]; })->toJson() }}" placeholder="{{ trans('admin.comparison.columns.scheme') }}" label="title" track-by="id" :multiple="false"></multiselect>
                <div v-if="errors.has('schemes')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('schemes') }}</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3 align-items-center d-flex justify-content-center">
        <a v-on:click.stop="deleteScheme(index);" class="btn btn-danger" style="color: white">
            {{ trans('admin.comparison.columns.delete_scheme') }}
        </a>
    </div>
</div>
</div>

<div class="row">
    <div class="col-12 col-md-12 text-center mt-5">
        <a v-on:click.stop="addScheme" class="btn btn-primary" style="color: white">
            <i class="fa fa-plus"></i> {{ trans('admin.comparison.columns.add_scheme') }}
        </a>
    </div>
</div>
</div>