<?php

namespace Tests\Unit\Services\Customer;

use App\Entities\Customer;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Services\Customer\CustomerService;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerServiceTest extends \TestCase
{
    private CustomerRepositoryInterface|MockObject $customerRepositoryMock;

    private CustomerService|MockObject $customerService;

    public function setUp(): void
    {
        parent::setUp();

        $this->customerRepositoryMock = \Mockery::mock(CustomerRepositoryInterface::class);
        $this->customerService = new CustomerService($this->customerRepositoryMock);
    }

    public function testFindByIdSuccess()
    {
        $newCustomer = entity(Customer::class, 'customer')->make();;

        $this->customerRepositoryMock
            ->shouldReceive('find')
            ->once()
            ->andReturn($newCustomer);


        $customer = $this->customerService->findById(1);
        $this->assertInstanceOf(Customer::class, $customer);
    }

   public function testFindAllSuccess()
   {
       $customerList = entity(Customer::class, 'customer', 2)->make();

       $this->customerRepositoryMock
           ->shouldReceive('findAll')
           ->once()
           ->andReturn($customerList);

       $customers = $this->customerService->findAll();

       $this->assertIsIterable($customers);
       $this->assertContainsOnlyInstancesOf(Customer::class, $customers);
   }

}
