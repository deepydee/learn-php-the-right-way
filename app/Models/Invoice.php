<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Models;
use Synthex\Phptherightway\Core\Model;

class Invoice extends Model
{
    public function create(
        float $amount,
        int $userId,
    ): int {
        $stmt = $this->db->prepare(
            'INSERT INTO invoices (amount, user_id)
             VALUES (:amount, :user_id)'
        );

        $stmt->execute([
            ':amount' => $amount,
            ':user_id' => $userId,
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function find(int $invoiceId): \StdClass
    {
        $stmt = $this->db->prepare(
            'SELECT
                invoices.id,
                invoices.amount,
                invoices.user_id,
                users.email,
                users.full_name
            FROM invoices
                LEFT JOIN users
                    ON invoices.user_id = users.id
            WHERE invoices.id = :id'
        );

        $stmt->execute([':id' => $invoiceId]);

        $invoice = $stmt->fetch();

        return $invoice ? $invoice : new \StdClass();
    }
}
