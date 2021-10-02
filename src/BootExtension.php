<?php

namespace GarbuzIvan\LogViewer;

use Encore\Admin\Admin;

trait BootExtension
{
    /**
     * {@inheritdoc}
     */
    public static function boot()
    {
        static::registerRoutes();

        Admin::extend('log-viewer', __CLASS__);
    }

    /**
     * Register routes for laravel-admin.
     *
     * @return void
     */
    protected static function registerRoutes()
    {
        parent::routes(function ($router) {
            /* @var \Illuminate\Routing\Router $router */
            $router->get('logs', 'GarbuzIvan\LogViewer\LogController@index')->name('log-viewer-index');
            $router->get('logs/{file}', 'GarbuzIvan\LogViewer\LogController@index')->name('log-viewer-file');
            $router->get('logs/{file}/tail', 'GarbuzIvan\LogViewer\LogController@tail')->name('log-viewer-tail');
            $router->get('logs/{file}/trash', 'GarbuzIvan\LogViewer\LogController@trash')->name('log-viewer-trash');
        });
    }

    /**
     * {@inheritdoc}
     */
    public static function import()
    {
        parent::createMenu('Log viewer', 'logs', 'fa-database');

        parent::createPermission('Logs', 'ext.log-viewer', 'logs*');
    }
}
