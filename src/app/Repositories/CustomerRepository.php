<?php

namespace App\Repositories;

use App\Repositories\Contracts\CustomerRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class CustomerRepository extends EntityRepository implements CustomerRepositoryInterface
{
    public function __construct(EntityManagerInterface $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
    }

    public function findByEmail(string $email)
    {
        return $this->findBy(['email' => $email]);
    }
}
