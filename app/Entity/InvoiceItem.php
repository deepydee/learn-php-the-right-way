<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Synthex\Phptherightway\Entity\Invoice;

#[Entity]
#[Table(name: 'invoice_items')]
class InvoiceItem
{
    #[Id]
    #[Column, GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Column(name: 'invoice_id')]
    private int $invoiceId;

    #[Column(name: 'description')]
    private string $description;

    #[Column(name: 'quantity')]
    private int $quantity;

    #[Column(name: 'unit_price', type: Types::DECIMAL, precision: 10, scale: 2)]
    private float $unitPrice;

    #[ManyToOne(inversedBy: 'items')]
    private Invoice $invoice;

    public function getId(): int
    {
        return $this->id;
    }

    public function getInvoiceId(): int
    {
        return $this->invoiceId;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    public function getInvoice(): Invoice
    {
        return $this->invoice;
    }

    public function setInvoiceId(int $invoiceId): InvoiceItem
    {
        $this->invoiceId = $invoiceId;
        return $this;
    }

    public function setDescription(string $description): InvoiceItem
    {
        $this->description = $description;
        return $this;
    }

    public function setQuantity(int $quantity): InvoiceItem
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function setUnitPrice(float $unitPrice): InvoiceItem
    {
        $this->unitPrice = $unitPrice;
        return $this;
    }

    public function setInvoice(Invoice $invoice): InvoiceItem
    {
        $this->invoice = $invoice;
        return $this;
    }
}
