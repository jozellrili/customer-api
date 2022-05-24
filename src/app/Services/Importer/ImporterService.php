<?php

namespace App\Services\Importer;

use GuzzleHttp\Client;

class ImporterService implements ImporterInterface
{
    private string $url = 'https://randomuser.me/api/';

    public function fetchUsers(int $count, string $country)
    {
        $params = [
            'results' => $count ,
            'nat' => $country,
        ];

        $httpClient = new Client();
        $request = $httpClient->get($this->url . '?' .http_build_query($params));
        $response = $request->getBody()->getContents();

        return json_decode($response);
    }
}
