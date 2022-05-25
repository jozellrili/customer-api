<?php

namespace App\Services\Customer;

use App\Repositories\CustomerRepository;

class CustomerService
{
    private CustomerRepository $repository;

    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function findById(int $id)
    {
        return $this->repository->find($id);
    }
}
