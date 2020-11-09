<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/layouts') }}"><i class="nav-icon icon-umbrella"></i> {{ trans('admin.layout.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/sliders') }}"><i class="nav-icon icon-energy"></i> {{ trans('admin.slider.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/checkboxes') }}"><i class="nav-icon icon-compass"></i> {{ trans('admin.checkbox.title') }}</a></li>
           {{-- Do not delete me :) I'm used for auto-generation menu items --}}

            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon icon-user"></i> Administrátori</a></li>
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
