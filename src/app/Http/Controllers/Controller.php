<?php

namespace App\Http\Controllers;

use App\Http\Traits\HttpStatusCodesTrait;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use HttpStatusCodesTrait;
}
