<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Models;

use Synthex\Phptherightway\Core\Model;
use Synthex\Phptherightway\Factories\TicketFactory;

class Ticket extends Model
{
    public function all(): \Generator
    {
        $stmt = $this->db->query(
            'SELECT * FROM tickets'
        );

        return $this->fetchLazy($stmt);
    }

    public function seed(): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO tickets (title, content, user_id, template_id)
          VALUES (?, ?, ?, ?)'
        );

        try {

            foreach (TicketFactory::make()->create(30000) as $tickets) {
                // Build bind parameters for the batch
                $params = [];

                foreach ($tickets as $ticket) {
                    $params[] = [
                        $ticket['title'],
                        $ticket['content'],
                        $ticket['user_id'],
                        $ticket['template_id'],
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
