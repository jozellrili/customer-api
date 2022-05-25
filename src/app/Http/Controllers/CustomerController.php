<?php

namespace App\Http\Controllers;

use App\Entities\Customer;
use App\Services\Customer\CustomerTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var CustomerTransformer
     */
    private CustomerTransformer $transformer;

    /**
     * @param EntityManagerInterface $entityManager
     * @param CustomerTransformer $transformer
     */
    public function __construct(EntityManagerInterface $entityManager, CustomerTransformer $transformer)
    {
        $this->entityManager = $entityManager;
        $this->transformer = $transformer;
    }

    /**
     * @return JsonResponse
     */
    public function getCustomers(): JsonResponse
    {
        $data = [];
        try {
            $customers = $this->entityManager->getRepository(Customer::class)->findAll();
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
            $customer = $this->entityManager->getRepository(Customer::class)->find($id);
            $data = $this->transformer->transformData($customer);
        } catch (\Exception $e) {
            $data['error'] = $e->getMessage();
        }

        return response()->json($data);
    }
}
