<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Attributes;

use Attribute;
use Synthex\Phptherightway\Attributes\Route;
use Synthex\Phptherightway\Enums\RequestMethod;

#[Attribute(Attribute::TARGET_METHOD)]
class Post extends Route
{
    public function __construct(public string $path)
    {
        parent::__construct($path, RequestMethod::POST);
    }
}
