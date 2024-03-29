<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">{{ trans('admin.experiment.settings') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/layouts') }}"><i class="nav-icon icon-umbrella"></i> {{ trans('admin.layout.title') }}</a></li>
            <li class="nav-title">{{ trans('admin.experiment.components') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/sliders') }}"><i class="nav-icon icon-energy"></i> {{ trans('admin.slider.title') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/checkboxes') }}"><i class="nav-icon icon-compass"></i> {{ trans('admin.checkbox.title') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/comparison-experiments') }}"><i class="nav-icon icon-graduation"></i> {{ trans('admin.comparison-experiment.title') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/examples') }}"><i class="nav-icon icon-ghost"></i> {{ trans('admin.example.title') }}</a></li>
            <li class="nav-title">{{ trans('admin.experiment.experiments') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/experiments') }}"><i class="nav-icon icon-flag"></i> {{ trans('admin.experiment.title') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/nyquist-experiments') }}"><i class="nav-icon icon-flag"></i> {{ trans('admin.nyquist_experiment.title') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/comparisons') }}"><i class="nav-icon icon-drop"></i> {{ trans('admin.comparison.title') }}</a></li>

            {{-- Do not delete me :) I'm used for auto-generation menu items --}}

            <li class="nav-title">{{ trans('admin.experiment.admin') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon icon-user"></i> {{ trans('admin.admin-user.title') }}</a></li>
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
