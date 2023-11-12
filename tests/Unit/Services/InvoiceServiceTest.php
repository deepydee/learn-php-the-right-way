<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use Synthex\Phptherightway\Services\EmailService;
use Synthex\Phptherightway\Services\InvoiceService;
use Synthex\Phptherightway\Services\PaymentGatewayService;
use Synthex\Phptherightway\Services\SalesTaxService;

class InvoiceServiceTest extends TestCase
{
    private $salesTaxServiceMock;
    private $gatewayServiceMock;
    private $emailServiceMock;
    private $invoiceService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->salesTaxServiceMock = $this->createMock(SalesTaxService::class);
        $this->gatewayServiceMock = $this->createMock(PaymentGatewayService::class);
        $this->emailServiceMock = $this->createMock(EmailService::class);

        $this->gatewayServiceMock->method('charge')->willReturn(true);

        $this->invoiceService = new InvoiceService(
            $this->salesTaxServiceMock,
            $this->gatewayServiceMock,
            $this->emailServiceMock
        );
    }

    public function test_it_processes_invoice(): void
    {
        $result = $this->invoiceService->process(['name' => 'John'], 100);

        $this->assertTrue($result);
    }

    public function test_it_sends_receipt_email_when_invoice_is_processed(): void
    {
        $this->emailServiceMock
            ->expects($this->once())
            ->method('send')
            ->with(['name' => 'John'], 'Receipt');

        $this->invoiceService->process(['name' => 'John'], 100);
    }
}
