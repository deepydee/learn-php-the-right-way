<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Exceptions;

class ViewNotFoundException extends \Exception
{
    protected $message = 'View not found';
}
