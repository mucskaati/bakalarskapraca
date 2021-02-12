<?php

namespace App\Providers;

use App\Models\Experiment;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.app', function ($view) {
            $view->with('fos', Experiment::where('type', 'fo')->orWhere('type', null)->get())->withComparisons(Experiment::where('type', 'comparison')->get());
        });
    }
}
