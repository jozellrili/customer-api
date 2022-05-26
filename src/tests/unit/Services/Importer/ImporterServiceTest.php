<?php

namespace Tests\Unit\Services\Importer;

use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Services\Importer\ApiResponseValidation;
use App\Services\Importer\ImporterService;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class ImporterServiceTest extends \TestCase
{
    /**
     * @param array $randomUsers
     * @return void
     * @throws GuzzleException
     * @dataProvider randomUsersDataProvider
     */
    public function testFetchUsersSuccess(array $randomUsers): void
    {
        $apiResponseValidation = $this->createMock(ApiResponseValidation::class);
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $customerRepository = $this->createMock(CustomerRepositoryInterface::class);

        $mock = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], json_encode($randomUsers)),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $importerService = new ImporterService(
            $apiResponseValidation,
            $client,
            $entityManager,
            $customerRepository,
            'https://random-users.com/test'
        );

        $customerRepository
            ->expects($this->any())
            ->method('findByEmail')
            ->with($randomUsers['results'][0]['email'])
            ->willReturn([]);

        $fetchedUsers = $importerService->fetchUsers(1, 'au');

        $this->assertArrayHasKey('message', $fetchedUsers);
        $this->assertEquals('Users imported successfully', $fetchedUsers['message']);
    }

    private function randomUsersDataProvider(): array
    {
        return [
            'json' => [
                [
                    'results' => [
                        [
                            'gender' => 'male',
                            'name' => [
                                'title' => 'Mr',
                                'first' => 'Ernest',
                                'last' => 'Dixon',
                            ],
                            'location' => [
                                'street' => [
                                    'number' => 9723,
                                    'name' => 'Spring Hill Rd',
                                ],
                                'city' => 'Bowral',
                                'state' => 'Australian Capital Territory',
                                'country' => 'Australia',
                                'postcode' => 4894,
                                'coordinates' => [
                                    'latitude' => '79.9271',
                                    'longitude' => '-78.7421',
                                ],
                                'timezone' => [
                                    'offset' => '+7=>00',
                                    'description' => 'Bangkok, Hanoi, Jakarta',
                                ],
                            ],
                            'email' => 'ernest.dixon@example.com',
                            'login' => [
                                'uuid' => '53cfc21b-527a-4b2a-9ed1-ca84f7f4257e',
                                'username' => 'ticklishbird812',
                                'password' => 'topdog',
                                'salt' => 'vlCOTjQf',
                                'md5' => 'dd574a0318fbae7cb85a600e3244a9bb',
                                'sha1' => '7c6e0a392b6873cef04ceea6b76704d55b809983',
                                'sha256' => '728127e369843b5e18faa90e9c22ba03acb803b27026172620901826f4de0ab9',
                            ],
                            'dob' => [
                                'date' => '1981-06-26T06=>59=>11.084Z',
                                'age' => 41,
                            ],
                            'registered' => [
                                'date' => '2011-12-16T00=>08=>04.165Z',
                                'age' => 11,
                            ],
                            'phone' => '09-4921-3497',
                            'cell' => '0402-173-223',
                            'id' => [
                                'name' => 'TFN',
                                'value' => '794309708',
                            ],
                            'picture' => [
                                'large' => 'https=>//randomuser.me/api/portraits/men/29.jpg',
                                'medium' => 'https=>//randomuser.me/api/portraits/med/men/29.jpg',
                                'thumbnail' => 'https=>//randomuser.me/api/portraits/thumb/men/29.jpg',
                            ],
                            'nat' => 'AU',
                        ],
                    ],
                    'info' => [
                        'seed' => '0edd0f51ebc22c1c',
                        'results' => 1,
                        'page' => 1,
                        'version' => '1.3',
                    ],
                ],
            ],
        ];
    }

}
