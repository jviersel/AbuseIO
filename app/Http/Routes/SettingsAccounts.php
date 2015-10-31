<?php
Route::model('accounts', 'AbuseIO\Models\Account');
Route::resource('accounts', 'AccountsController');

Route::group(
    [
        'prefix' => 'accounts',
    ],
    function () {
        // Access to index list
        route::get(
            '',
            [
                'middleware' => 'permission:admin_accounts_view',
                'as' => 'admin.accounts.index',
                'uses' => 'AccountsController@index'
            ]
        );

        // Access to show object
        route::get(
            '{accounts}',
            [
                'middleware' => 'permission:admin_accounts_view',
                'as' => 'admin.accounts.show',
                'uses' => 'AccountsController@show'
            ]
        );

        // Access to export object
        route::get(
            'export',
            [
                'middleware' => 'permission:admin_accounts_export2',
                'as' => 'admin.accounts.export',
                'uses' => 'AccountsController@export'
            ]
        );

        // Access to create object
        route::get(
            'create',
            [
                'middleware' => 'permission:admin_accounts_create',
                'as' => 'admin.accounts.create',
                'uses' => 'AccountsController@create'
            ]
        );
        route::post(
            '',
            [
                'middleware' => 'permission:admin_accounts_create',
                'as' => 'admin.accounts.store',
                'uses' => 'AccountsController@store'
            ]
        );

        // Access to edit object
        route::get(
            '{accounts}/edit',
            [
                'middleware' => 'permission:admin_accounts_edit',
                'as' => 'admin.accounts.edit',
                'uses' => 'AccountsController@edit'
            ]
        );
        route::patch(
            '{accounts}',
            [
                'middleware' => 'permission:admin_accounts_edit',
                'as' => '',
                'uses' => 'AccountsController@update'
            ]
        );
        route::put(
            '{accounts}',
            [
                'middleware' => 'permission:admin_accounts_edit',
                'as' => 'admin.accounts.update',
                'uses' => 'AccountsController@update'
            ]
        );

        // Access to delete object
        route::delete(
            '/{accounts}',
            [
                'middleware' => 'permission:admin_accounts_delete',
                'as' => 'admin.accounts.destroy',
                'uses' => 'AccountsController@destroy'
            ]
        );

    }
);
