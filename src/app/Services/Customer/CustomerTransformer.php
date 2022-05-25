<?php

namespace App\Services\Customer;

use App\Entities\Customer;

class CustomerTransformer
{
    /**
     * Transform the result of bulk customer data.
     *
     * @param array $customers
     * @return array
     */
    public function transformBulkData(array $customers): array
    {
        $data = [];
        foreach ($customers as $customer) {
            $data[] = [
                'full_name' => $customer->first_name . ' ' . $customer->last_name,
                'email' => $customer->email,
                'country' => $customer->country,
            ];
        }

        return $data;
    }


    /**
     * Transform the result of single customer data.
     *
     * @param Customer $customer
     * @return array
     */
    public function transformData(Customer $customer): array
    {
        return [
            'full_name' => $customer->getFirstName() . ' ' . $customer->getLastName(),
            'email' => $customer->getEmail(),
            'username' => $customer->getUsername(),
            'gender' => $customer->getGender(),
            'country' => $customer->getCountry(),
            'city' => $customer->getCity(),
            'phone' => $customer->getPhone(),
        ];
    }
}
