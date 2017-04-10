<?php
Route::group(['middleware' => ['web'], 'prefix' => config('admin.url'), 'as' => 'admin.newsletters'], function () {
    Route::group(['middleware' => ['auth.admin', 'auth.rules']], function () {
        Route::get('newsletters/trash', ['uses' => 'NewslettersAdminController@index', 'as' => '.trash']);
        Route::post('newsletters/restore/{id}', ['uses' => 'NewslettersAdminController@restore', 'as' => '.restore']);
        Route::resource('newsletters', 'NewslettersAdminController', [
            'names' => [
                'index' => '.index',
                'create' => '.create',
                'store' => '.store',
                'edit' => '.edit',
                'update' => '.update',
                'show' => '.show',
            ], 'except' => ['destroy']
        ]);
        Route::delete('newsletters/destroy', ['uses' => 'NewslettersAdminController@destroy', 'as' => '.destroy']);
        Route::get('newsletters/download', ['uses' => 'NewslettersAdminController@download', 'as' => '.download']);
    });

});