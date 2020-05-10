<?php

namespace Psylogic\SQLite\Database;


use Illuminate\Database\SQLiteConnection as BaseSQLiteConnection;
use Psylogic\SQLite\Database\Schema\Blueprint;

class SQLiteConnection extends BaseSQLiteConnection
{
    public function getSchemaBuilder()
    {
        $builder = parent::getSchemaBuilder();
        $builder->blueprintResolver(function ($table, $callback) {
            return new Blueprint($table, $callback);
        });
        return $builder;
    }
}
