<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Services;

class PaymentGatewayService
{
    public function charge(float $amount, array $customer, float $tax): bool
    {
        sleep(1);

        return (bool) mt_rand(0, 1);
    }
}
