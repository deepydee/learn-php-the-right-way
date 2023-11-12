<?php

declare(strict_types=1);

namespace Tests\DataProviders;

use Synthex\Phptherightway\Enums\RequestMethod;

class RouterDataProvider
{
    public static function routeNotFoundCases(): array
    {
        return [
            'method doesnt exist' => ['/users', RequestMethod::PUT],
            'uri doesnt exist' => ['/invoices', RequestMethod::POST],
            'correct uri, incorrect method' => ['/users', RequestMethod::GET],
            'incorrect combination of uri and method' => ['/users', RequestMethod::POST],
        ];
    }
}
