<?php

namespace App\Providers;

use App\Entities\Customer;
use App\Repositories\CustomerRepository;
use App\Services\Customer\CustomerService;
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
        $this->app->bind(CustomerRepository::class, function ($app) {
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new CustomerRepository(
                $this->app->get(EntityManagerInterface::class),
                $this->app->get(EntityManagerInterface::class)->getClassMetaData(Customer::class)
            );
        });

        $this->app->bind(ImporterService::class, function () {
            return new ImporterService(
                $this->app->get(ApiResponseValidation::class),
                $this->app->get(Client::class),
                $this->app->get(EntityManagerInterface::class),
                $this->app->get(CustomerRepository::class),
                \config('random_user_api.url')
            );
        });

        $this->app->bind(CustomerService::class, function () {
            return new CustomerService($this->app->get(CustomerRepository::class));
        });
    }
}
