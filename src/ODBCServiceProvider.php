<?php

namespace Abram\Odbc;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class ODBCServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->resolving('db', function ($db) {
            /** @var DatabaseManager $db */
            $db->extend('odbc', function ($config, $name) {
                $pdoConnection = (new ODBCConnector())->connect($config);
                $connection = new ODBCConnection($pdoConnection, $config['database'], isset($config['prefix']) ? $config['prefix'] : '', $config);
                return $connection;
            });
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        Model::setConnectionResolver($this->app['db']);
        Model::setEventDispatcher($this->app['events']);
    }
}
