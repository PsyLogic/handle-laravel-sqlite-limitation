<?php

namespace Psylogic\SQLite;

use Illuminate\Database\Connection;
use Illuminate\Support\ServiceProvider;
use Psylogic\SQLite\Database\SQLiteConnection;

class SQLiteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Connection::resolverFor('sqlite', function ($connection, $database, $prefix, $config) {
            return new SQLiteConnection($connection, $database, $prefix, $config);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
