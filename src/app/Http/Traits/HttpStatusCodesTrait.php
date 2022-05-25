<?php

namespace App\Http\Traits;

trait HttpStatusCodesTrait
{
    static $statusCodeOk           = 200;
    static $statusCodeBadRequest   = 400;
    static $statusCodeNotFound     = 404;
    static $statusCodeUnauthorized = 401;
    static $statusCodeUnprocessableEntity = 422;
    static $statusCodeInternalServerError = 500;
    static $statusCodeServiceUnavailable  = 503;
}
