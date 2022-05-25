<?php

namespace App\Providers;

use App\Services\Importer\ApiResponseValidation;
use App\Services\Importer\ImporterService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(ImporterService::class, function () {
            return new ImporterService(
                $this->app->get(ApiResponseValidation::class),
                $this->app->get(Client::class),
                Config::get('random_user_api.url')
            );
        });
    }
}
