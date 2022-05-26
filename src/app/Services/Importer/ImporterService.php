<?php

namespace App\Services\Importer;

use App\Entities\Customer;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Repositories\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;

class ImporterService implements ImporterInterface
{
    private Client $client;

    private string $apiUrl;

    private ApiResponseValidation $apiResponseValidation;

    private EntityManagerInterface $entityManager;

    private CustomerRepositoryInterface $customerRepository;

    /**
     * @param ApiResponseValidation $apiResponseValidation
     * @param Client $client
     * @param EntityManagerInterface $entityManager
     * @param CustomerRepositoryInterface $customerRepository
     * @param string $apiUrl
     */
    public function __construct(
        ApiResponseValidation $apiResponseValidation,
        Client $client,
        EntityManagerInterface $entityManager,
        CustomerRepositoryInterface $customerRepository,
        string $apiUrl)
    {
        $this->client = $client;
        $this->apiResponseValidation = $apiResponseValidation;
        $this->entityManager = $entityManager;
        $this->customerRepository = $customerRepository;
        $this->apiUrl = $apiUrl;
    }

    /**
     * @throws GuzzleException
     */
    public function fetchUsers(int $count, string $country): array
    {
        $params = http_build_query([
            'results' => $count,
            'nat' => $country,
        ]);

        try {
            $request = $this->client->get($this->apiUrl . '?' . $params);
            $response = json_decode($request->getBody()->getContents(), true);

            foreach ($response['results'] as $user) {
                $validator = \validator()->make($user, $this->apiResponseValidation->ruleFetchUsers());
                if (!$validator->fails()) {
                    $data = [
                        'first_name' => $user['name']['first'],
                        'last_name' => $user['name']['last'],
                        'email' => $user['email'],
                        'username' => $user['login']['username'],
                        'password' => $user['login']['password'],
                        'gender' => $user['gender'],
                        'country' => $user['location']['country'],
                        'city' => $user['location']['city'],
                        'phone' => $user['phone'],
                    ];

                    $this->saveFetchedUsers($data);
                }
            }

            $this->entityManager->flush();
        } catch (BadResponseException $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }

        return [
            'message' => 'Users imported successfully',
        ];
    }

    private function saveFetchedUsers(array $user)
    {
        $existingCustomer = $this->customerRepository->findByEmail($user['email']);

        if (count($existingCustomer)) {
            $customer = $this->customerRepository->find($existingCustomer[0]->getId());
        } else {
            $customer = new Customer();
        }

        $customer->setFirstName($user['first_name']);
        $customer->setLastName($user['last_name']);
        $customer->setGender($user['gender']);
        $customer->setCity($user['city']);
        $customer->setCountry($user['country']);
        $customer->setUsername($user['username']);
        $customer->setPassword(md5($user['password']));
        $customer->setPhone($user['phone']);
        $customer->setEmail($user['email']);
        $customer->setCreatedAt();
        $customer->setUpdatedAt();

        $this->entityManager->persist($customer);
    }
}
