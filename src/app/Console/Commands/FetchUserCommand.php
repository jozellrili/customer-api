<?php

namespace App\Console\Commands;

use App\Services\Importer\ImporterInterface;
use App\Services\Importer\ImporterService;
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

    public function handle()
    {
        try {
            $importer = new ImporterService();
            $users = $importer->fetchUsers(100, 'au');

            dump($users);
        } catch (\Exception $e) {
            $this->error('n error occurred: ' . $e->getMessage());
        }
    }
}
