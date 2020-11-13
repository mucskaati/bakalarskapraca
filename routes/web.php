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

Route::get('/', 'Frontend\GraphController@graph1')->name('home');


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
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('layouts')->name('layouts/')->group(static function() {
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
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('sliders')->name('sliders/')->group(static function() {
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
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('checkboxes')->name('checkboxes/')->group(static function() {
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
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('experiments')->name('experiments/')->group(static function() {
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