<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Exceptions;

class RouteNotFoundException extends \Exception
{
    protected $message = '404 Not Found';
}
