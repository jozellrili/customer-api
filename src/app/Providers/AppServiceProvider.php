<?php

namespace App\Providers;

use App\Services\Importer\ApiResponseValidation;
use App\Services\Importer\ImporterService;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
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
                $this->app->get(EntityManagerInterface::class),
                \config('random_user_api.url')
            );
        });
    }
}
