<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Services;

use Synthex\Phptherightway\Interfaces\PaymentGatewayServiceInterface;

class PaymentGatewayService implements PaymentGatewayServiceInterface
{
    public function charge(float $amount, array $customer, float $tax): bool
    {
        sleep(1);

        return (bool) mt_rand(0, 1);
    }
}
