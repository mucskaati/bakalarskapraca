<div class="row mb-5">
    <div class="col-12 col-md-12 text-center mb-3">
        <h5>{{ __('admin.experiment.steps.first') }}</h5>
    </div>
    <div class="col-md-12 text-center">
        <a href="{{ route('admin/comparison-experiments/create') }}" class="btn btn-primary d-inline-block mr-5">{{ __('admin.comparison.columns.add_schemes') }}</a>
    </div>
</div>
<div class="row mb-5">
    <div class="col-12 col-md-12 text-center mb-3">
        <h5>{{ __('admin.experiment.steps.second') }}</h5>
    </div>
    <div class="col-md-12 d-flex align-items-center justify-content-center">
        <a href="{{ route('admin/sliders/create') }}" class="btn btn-primary d-inline-block mr-5">{{ __('admin.comparison.columns.sliders_to_scheme') }}</a>
        <a href="{{ route('admin/checkboxes/create') }}" class="btn btn-primary d-inline-block">{{ __('admin.comparison.columns.checkboxes_to_scheme') }}</a>
    </div>
</div>