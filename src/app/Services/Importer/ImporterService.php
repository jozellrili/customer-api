<?php

namespace App\Services\Importer;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;

class ImporterService implements ImporterInterface
{
    private Client $client;

    private string $apiUrl;

    private ApiResponseValidation $apiResponseValidation;

    public function __construct(ApiResponseValidation $apiResponseValidation, Client $client, $apiUrl)
    {
        $this->client = $client;
        $this->apiResponseValidation = $apiResponseValidation;
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
            $data = [];

            foreach ($response['results'] as $user) {
                $validator = \validator()->make($user, $this->apiResponseValidation->ruleFetchUsers());
                if (!$validator->fails()) {
                    $data[] = [
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
                }
            }
        } catch (BadResponseException $e) {
            $data = [
                'error' => $e->getMessage(),
            ];
        }

        return $data;
    }

    public function saveFetchedUsers()
    {

    }
}
