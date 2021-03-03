<div class="row mb-5">
    <div class="col-12 col-md-12 text-center mb-3">
        <h5>{{ __('admin.experiment.steps.first') }}</h5>
    </div>
    <div class="col-md-12 d-flex align-items-center justify-content-center">
        <a href="{{ route('admin/sliders/create') }}" class="btn btn-primary d-inline-block mr-5">{{ __('admin.experiment.columns.add_slider') }}</a>
        <a href="{{ route('admin/checkboxes/create') }}" class="btn btn-primary d-inline-block">{{ __('admin.experiment.columns.add_checkbox') }}</a>
    </div>
</div>