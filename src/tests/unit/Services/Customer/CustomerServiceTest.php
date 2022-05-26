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
        $newCustomer = new Customer();
        $newCustomer->setFirstName('Jane');
        $newCustomer->setLastName('Doe');
        $newCustomer->setGender('female');
        $newCustomer->setCity('Norwa');
        $newCustomer->setCountry('Australia');
        $newCustomer->setUsername('jane.doe');
        $newCustomer->setPassword(md5('securepass123'));
        $newCustomer->setPhone('06-9063-9944');
        $newCustomer->setEmail('jane.doe@example.com');
        $newCustomer->setCreatedAt();
        $newCustomer->setUpdatedAt();

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
