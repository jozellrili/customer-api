<?php

namespace App\Http\Controllers;

use App\Entities\Customer;
use App\Services\Customer\CustomerService;
use App\Services\Customer\CustomerTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    /**
     * @var CustomerService
     */
    private CustomerService $service;

    /**
     * @var CustomerTransformer
     */
    private CustomerTransformer $transformer;

    /**
     * @param CustomerService $service
     * @param CustomerTransformer $transformer
     */
    public function __construct(CustomerService $service, CustomerTransformer $transformer)
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @return JsonResponse
     */
    public function getCustomers(): JsonResponse
    {
        $data = [];
        try {
            $customers = $this->service->findAll();
            $data = $this->transformer->transformBulkData(json_decode(json_encode($customers)));
        } catch (\Exception $e) {
            $data['error'] = $e->getMessage();
        }

        return response()->json($data);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function getCustomerById(int $id): JsonResponse
    {
        try {
            $validator = validator()->make(['id' => $id], ['id' => 'required|integer']);
            if ($validator->fails()) {
                throw new ValidationException($validator->messages());
            }

            $customer = $this->service->findById($id);

            if (!$customer instanceof Customer) {
                throw new \Exception('User not found!');
            }

            $statusCode = parent::$statusCodeOk;
            $data = $this->transformer->transformData($customer);
        } catch (\Exception $e) {
            $statusCode = parent::$statusCodeBadRequest;
            $data['error'] = $e->getMessage();
        }

        return response()->json($data, $statusCode);
    }
}
