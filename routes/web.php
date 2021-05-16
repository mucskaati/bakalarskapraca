<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Frontend\HomeController@index')->name('home');
Route::get('/single/{id}/{slug}', 'Frontend\GraphController@graph1')->name('graph_fo');
Route::get('/path/{id}/{slug}', 'Frontend\GraphController@graphNyquist')->name('graph_nyquist');
Route::get('/comp/{id}/{slug}', 'Frontend\GraphController@comparison')->name('comparison');

//Export PDF
Route::post('/export/pdf', 'Frontend\ExportPDFController@export')->name('export');
Route::post('/export/comparison/pdf', 'Frontend\ExportPDFController@exportComparisonPDF')->name('export.comparison');


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('admin-users')->name('admin-users/')->group(static function () {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('layouts')->name('layouts/')->group(static function () {
            Route::get('/',                                             'LayoutsController@index')->name('index');
            Route::get('/create',                                       'LayoutsController@create')->name('create');
            Route::post('/',                                            'LayoutsController@store')->name('store');
            Route::get('/{layout}/edit',                                'LayoutsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'LayoutsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{layout}',                                    'LayoutsController@update')->name('update');
            Route::delete('/{layout}',                                  'LayoutsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('sliders')->name('sliders/')->group(static function () {
            Route::get('/',                                             'SlidersController@index')->name('index');
            Route::get('/create',                                       'SlidersController@create')->name('create');
            Route::post('/',                                            'SlidersController@store')->name('store');
            Route::get('/{slider}/edit',                                'SlidersController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'SlidersController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{slider}',                                    'SlidersController@update')->name('update');
            Route::delete('/{slider}',                                  'SlidersController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('checkboxes')->name('checkboxes/')->group(static function () {
            Route::get('/',                                             'CheckboxesController@index')->name('index');
            Route::get('/create',                                       'CheckboxesController@create')->name('create');
            Route::post('/',                                            'CheckboxesController@store')->name('store');
            Route::get('/{checkbox}/edit',                              'CheckboxesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'CheckboxesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{checkbox}',                                  'CheckboxesController@update')->name('update');
            Route::delete('/{checkbox}',                                'CheckboxesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('experiments')->name('experiments/')->group(static function () {
            Route::get('/',                                             'ExperimentsController@index')->name('index');
            Route::get('/create',                                       'ExperimentsController@create')->name('create');
            Route::post('/',                                            'ExperimentsController@store')->name('store');
            Route::get('/{experiment}/edit',                            'ExperimentsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ExperimentsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{experiment}',                                'ExperimentsController@update')->name('update');
            Route::delete('/{experiment}',                              'ExperimentsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('nyquist-experiments')->name('nyquist.experiments/')->group(static function () {
            Route::get('/',                                             'NyquistExperimentsController@index')->name('index');
            Route::get('/create',                                       'NyquistExperimentsController@create')->name('create');
            Route::post('/',                                            'NyquistExperimentsController@store')->name('store');
            Route::get('/{experiment}/edit',                            'NyquistExperimentsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'NyquistExperimentsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{experiment}',                                'NyquistExperimentsController@update')->name('update');
            Route::delete('/{experiment}',                              'NyquistExperimentsController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('comparison-experiments')->name('comparison-experiments/')->group(static function () {
            Route::get('/',                                             'ComparisonExperimentsController@index')->name('index');
            Route::get('/create',                                       'ComparisonExperimentsController@create')->name('create');
            Route::post('/',                                            'ComparisonExperimentsController@store')->name('store');
            Route::get('/{comparisonExperiment}/edit',                  'ComparisonExperimentsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ComparisonExperimentsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{comparisonExperiment}',                      'ComparisonExperimentsController@update')->name('update');
            Route::delete('/{comparisonExperiment}',                    'ComparisonExperimentsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('comparisons')->name('comparisons/')->group(static function () {
            Route::get('/',                                             'ComparisonsController@index')->name('index');
            Route::get('/create',                                       'ComparisonsController@create')->name('create');
            Route::post('/',                                            'ComparisonsController@store')->name('store');
            Route::get('/{comparison}/edit',                            'ComparisonsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ComparisonsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{comparison}',                                'ComparisonsController@update')->name('update');
            Route::delete('/{comparison}',                              'ComparisonsController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('examples')->name('examples/')->group(static function () {
            Route::get('/',                                             'ExamplesController@index')->name('index');
            Route::get('/create',                                       'ExamplesController@create')->name('create');
            Route::post('/',                                            'ExamplesController@store')->name('store');
            Route::get('/{example}/edit',                               'ExamplesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ExamplesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{example}',                                   'ExamplesController@update')->name('update');
            Route::delete('/{example}',                                 'ExamplesController@destroy')->name('destroy');
        });
    });
});
