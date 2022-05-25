<?php

namespace App\Services\Importer;

class ApiResponseValidation
{
    /**
     * Validation rules for the API Response
     * @return string[]
     */
    public function ruleFetchUsers(): array
    {
        return [
            'name.first' => 'required',
            'name.last' => 'required',
            'email' => 'required|email',
            'login.username' => 'required',
            'login.password' => 'required',
            'gender' => 'required|alpha',
            'location.country' => 'required',
            'location.city' => 'required',
            'phone' => 'required',
        ];
    }
}
