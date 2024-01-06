<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Attributes;

use Attribute;
use Synthex\Phptherightway\Contracts\RouteInterface;
use Synthex\Phptherightway\Enums\RequestMethod;

#[Attribute]
class Route implements RouteInterface
{
    public function __construct(
        public string $path,
        public RequestMethod $method = RequestMethod::GET,
    ) {}
}
