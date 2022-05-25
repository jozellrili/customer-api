<?php

namespace App\Services\Importer;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;

class ImporterService implements ImporterInterface
{
    private string $url = 'https://randomuser.me/api/';

    /**
     * @throws GuzzleException
     */
    public function fetchUsers(int $count, string $country): array
    {
        $params = [
            'results' => $count,
            'nat' => $country,
        ];

        $data = [];
        try {
            $httpClient = new Client();
            $request = $httpClient->get($this->url . '?' . http_build_query($params));
            $response = json_decode($request->getBody()->getContents(), true);

            $data['users'] = array_map(function ($user) {
                return [
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
            }, $response['results']);
        } catch (BadResponseException $e) {
            $data = [
                'error' => $e->getMessage(),
            ];
        }

        return $data;
    }
}
