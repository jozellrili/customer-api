<?php

namespace App\Console\Commands;

use App\Services\Importer\ImporterInterface;
use App\Services\Importer\ImporterService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class FetchUserCommand extends Command
{
    /**
     * Console command name
     * @var string
     */
    protected $signature = 'user:fetch';

    /**
     * Console command description
     * @var string
     */
    protected $description = 'Fetch users from RandomMe API';

    /**
     * @throws GuzzleException
     */
    public function handle(ImporterService $importerService)
    {
        $users = $importerService->fetchUsers(2, 'au');
        dump($users);
    }
}
