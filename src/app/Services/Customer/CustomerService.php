<?php

namespace App\Services\Customer;

use App\Repositories\Contracts\CustomerRepositoryInterface;

class CustomerService
{
    private CustomerRepositoryInterface $repository;

    /**
     * @param CustomerRepositoryInterface $repository
     */
    public function __construct(CustomerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findById(int $id)
    {
        return $this->repository->find($id);
    }
}
