<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Seeders;

use Synthex\Phptherightway\Factories\TicketFactory;
use Synthex\Phptherightway\Core\App;

class TicketSeeder
{
    public function __construct(private App $app)
    {
    }

    public function seed(): void
    {
        $stmt = $this->app::db->prepare(
            'INSERT INTO users (email, full_name, is_active, created_at, updated_at)
            VALUES (:email, :full_name, :is_active, :created_at, :updated_at)'
        );

        foreach (TicketFactory::make()->create(10) as $ticket) {
            $stmt->execute([
                ':title' => $ticket['title'],
                ':content' => $ticket['content'],
                ':user_id' => $ticket['user_id'],
                ':template_id' => $ticket['template_id'],
            ]);
        }
    }
}
