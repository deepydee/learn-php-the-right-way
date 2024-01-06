<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Models;
use PDO;
use Synthex\Phptherightway\Core\Model;
use Synthex\Phptherightway\Enums\InvoiceStatus;
use Synthex\Phptherightway\Factories\InvoiceFactory;

class Invoice extends Model
{
    public function all(InvoiceStatus $status): array
    {
        $stmt = $this->db->prepare(
            'SELECT id, invoice_number, amount, status
             FROM invoices
             WHERE status = ?'
        );

        $stmt->execute([$status->value]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

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

    public function seed(): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO invoices (invoice_number, amount, status)
          VALUES (?, ?, ?)'
        );

        try {

            foreach (InvoiceFactory::make()->create(300) as $invoices) {
                // Build bind parameters for the batch
                $params = [];

                foreach ($invoices as $invoices) {
                    $params[] = [
                        $invoices['invoice_number'],
                        $invoices['amount'],
                        $invoices['status'],
                    ];
                }

                // Insert all tickets
                $this->db->beginTransaction();
                foreach ($params as $param) {
                    $stmt->execute($param);
                }
                $this->db->commit();
            }


        } catch (\PDOException $e) {
            $this->db->rollback();
        }
    }
}
