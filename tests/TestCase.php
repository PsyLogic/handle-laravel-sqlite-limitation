<?php

namespace Psylogic\SQLite\Test;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Psylogic\SQLite\SQLiteServiceProvider;

class TestCase extends OrchestraTestCase
{
	/**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh', ['--database' => 'testing']);
	 }
	 
	/**
	 * Load package service provider
	 * @param  \Illuminate\Foundation\Application $app
	 * @return Psylogic\SQLite\SQLiteServiceProvider
	 */
	protected function getPackageProviders($app)
	{
		return [SQLiteServiceProvider::class];
	}

	/**
 * Define environment setup.
 *
 * @param  \Illuminate\Foundation\Application  $app
 * @return void
 */
protected function getEnvironmentSetUp($app)
{
    // Setup default database to use sqlite :memory:
    $app['config']->set('database.default', 'sqlite');
    $app['config']->set('database.connections.sqlite', [
        'driver'   => 'sqlite',
        'database' => ':memory:',
        'prefix'   => '',
    ]);
}
}
