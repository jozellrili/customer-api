<?php

namespace App\Repositories\Contracts;

interface CustomerRepositoryInterface
{
    public function findByEmail(string $email);
}
