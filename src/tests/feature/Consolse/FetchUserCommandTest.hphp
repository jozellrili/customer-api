<?php

namespace Tests\Feature\Console;

use App\Services\Importer\ImporterService;

class FetchUserCommandTest extends \TestCase
{
    public function testCommandSuccess()
    {
        $mock = \Mockery::mock(ImporterService::class);
        $mock->shouldReceive('fetchUsers')->andReturn([]);

        $this->app->instance(ImporterService::class, $mock);

        $result = $this->artisan('user:fetch 1 au');

        $this->assertEquals(0, $result);
    }

    public function testCommandSuccessWithParameter()
    {
        $mock = \Mockery::mock(ImporterService::class);
        $mock->shouldReceive('fetchUsers')->with(1, 'au')->andReturn([]);

        $this->app->instance(ImporterService::class, $mock);

        $result = $this->artisan('user:fetch 1 au');

        $this->assertEquals(0, $result);
    }
}
