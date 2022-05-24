<?php

namespace App\Services\Importer;

interface ImporterInterface
{
    public function fetchUsers(int $count, string $country);
}
