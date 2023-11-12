<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Services;

class InvoiceService
{
    public function __construct(
        protected SalesTaxService $salesTaxService,
        protected PaymentGatewayService $gatewayService,
        protected EmailService $emailService,
    ) {
    }

    public function process(array $customer, float $amount): bool
    {
        $tax = $this->salesTaxService->calculate($amount, $customer);

        if (!$this->gatewayService->charge($amount, $customer, $tax)) {
            return false;
        }

        $this->emailService->send($customer, 'Receipt');

        echo 'Invoice has been processed successfully<br>';

        return true;
    }
}
