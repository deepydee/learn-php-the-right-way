<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Models;
use Synthex\Phptherightway\Core\Model;

class User extends Model
{
    public function create(
        string $email,
        string $name,
        bool $isActive = true,
    ): int {
        $stmt = $this->db->prepare(
            'INSERT INTO users (email, full_name, is_active, created_at, updated_at)
            VALUES (:email, :full_name, :is_active, :created_at, :updated_at)'
        );

        $stmt->execute([
            ':email' => $email,
            ':full_name' => $name,
            ':is_active' => true,
            ':created_at' => date('Y-m-d H:i:s', time()),
            ':updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function all(): array
    {
        $stmt = $this->db->prepare(
            'SELECT  * FROM users'
        );

        $stmt->execute();

        return $stmt->fetchAll();
    }
}
