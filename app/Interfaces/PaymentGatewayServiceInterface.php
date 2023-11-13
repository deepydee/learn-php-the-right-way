<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Interfaces;

interface PaymentGatewayServiceInterface
{
    public function charge(float $amount, array $customer, float $tax): bool;
}
