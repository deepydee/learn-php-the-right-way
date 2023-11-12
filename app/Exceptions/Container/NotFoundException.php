<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Exceptions\Container;

use Psr\Container\NotFoundExceptionInterface;

class NotFoundException extends \Exception implements NotFoundExceptionInterface
{
}
