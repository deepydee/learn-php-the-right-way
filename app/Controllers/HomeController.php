<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Controllers;

use Synthex\Phptherightway\Core\App;
use Synthex\Phptherightway\Core\View;

class HomeController
{
    public function index(): View
    {
        $db = App::db();

        $email = 'vito666@hooligan11.com';
        $name = 'Vitalii Hooligan';
        $amount = 250;

        try {
            $db->beginTransaction();

            $newUserStmt = $db->prepare(
                'INSERT INTO users (email, full_name, is_active, created_at, updated_at)
             VALUES (:email, :full_name, :is_active, :created_at, :updated_at)'
            );

            $newInvoiceStmt = $db->prepare(
                'INSERT INTO invoices (amount, user_id)
             VALUES (:amount, :user_id)'
            );

            $newUserStmt->execute([
                ':email' => $email,
                ':full_name' => $name,
                ':is_active' => true,
                ':created_at' => date('Y-m-d H:i:s', time()),
                ':updated_at' => date('Y-m-d H:i:s', time()),
            ]);

            $userId = (int) $db->lastInsertId();

            // throw new \Exception('Test');

            $newInvoiceStmt->execute([
                ':amount' => $amount,
                ':user_id' => $userId,
            ]);

            $db->commit();
        } catch (\Throwable $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }

            throw $e;
        }

        $fetchStmt = $db->prepare(
            'SELECT
                invoices.id AS invoice_id,
                amount,
                user_id,
                full_name
            FROM
                invoices
                INNER JOIN users
                    ON users.id = invoices.user_id
            WHERE
                email = :email'
        );

        $fetchStmt->execute([
            ':email' => $email,
        ]);

        echo '<pre>';
        var_dump($fetchStmt->fetch());
        echo '</pre>';

        return View::make('index', ['foo' => 'bar']);
    }

    public function download()
    {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="invoice.pdf"');

        readfile(STORAGE_PATH . '/Пример.pdf');
    }

    public function upload(): void
    {
        $filePath = STORAGE_PATH . '/' . $_FILES['receipt']['name'];

        move_uploaded_file($_FILES['receipt']['tmp_name'], $filePath);

        header('Location: /');

        exit;
    }
}
