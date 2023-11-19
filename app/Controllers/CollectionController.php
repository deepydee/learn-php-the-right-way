<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Controllers;

use Synthex\Phptherightway\Core\Collection\Collection;

class CollectionController
{
    public function index()
    {
        $employees = Collection::make([
            ['name' => 'John', 'email' => 'j@j.j', 'salaried' => true],
            ['name' => 'Jane', 'email' => 'j@j.j', 'salaried' => false],
            ['name' => 'Jack', 'email' => 'j@j.j', 'salaried' => true],
        ]);

        $numberOfSalariedEmployees = $employees
            ->filter(fn(array $employee) => $employee['salaried'])
            ->count();

        echo 'Number of salaried employees: ' . $numberOfSalariedEmployees;
    }
}
