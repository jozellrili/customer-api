<?php

namespace Tests\Feature;

class CustomerTest extends \TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testGetAllCustomersSuccess()
    {
        $this->get('/customers');
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            [
                'full_name',
                'email',
                'country',
            ],
        ]);
    }

    public function testGetCustomerSuccess()
    {
        $this->get('/customers/1');
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'full_name',
            'email',
            'username',
            'gender',
            'country',
            'city',
            'phone',
        ]);
    }

    public function testGetCustomerFailDueToInvalidId()
    {
        $this->get('/customers/abc');
        $this->seeStatusCode(500);
    }

    public function testGetCustomerFailDueToNonExistingID()
    {
        $this->get('/customers/999999999');
        $this->seeStatusCode(400);
    }
}
