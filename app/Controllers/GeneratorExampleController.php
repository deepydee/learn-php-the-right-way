<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Controllers;

use Synthex\Phptherightway\Models\Ticket;

class GeneratorExampleController
{
    public function __construct(private Ticket $ticket)
    {
    }

    public function index()
    {
       foreach ($this->ticket->all() as $ticket) {
           echo $ticket->id . ': ' . substr($ticket->content, 0, 10).  '<br>';
       }
    }

    private function lazyRange(int $start, float $end): \Generator
    {
        echo 'Hello';

        for ($i = $start; $i <= $end; $i++) {
            yield $i * 5 => $i;
        }
    }
}
