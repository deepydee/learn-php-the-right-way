<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Runners;
use Synthex\Phptherightway\Core\Collection;

class GetUserEmails
{
    private array $users = [
        ['first_name' => 'John', 'last_name' => 'Smith', 'email' => 'john.smith@example.com'],
        ['first_name' => 'Jane', 'last_name' => 'Doe', 'email' => 'jane.doe@example.com'],
        ['first_name' => 'Bob', 'last_name' => 'Johnson', 'email' => 'bob.johnson@example.com'],
        ['first_name' => 'Samantha', 'last_name' => 'Lee', 'email' => 'samantha.lee@example.com'],
        ['first_name' => 'David', 'last_name' => 'Williams', 'email' => 'david.williams@example.com'],
        ['first_name' => 'Ashley', 'last_name' => 'Garcia', 'email' => 'ashley.garcia@example.com'],
        ['first_name' => 'Christopher', 'last_name' => 'Miller', 'email' => 'christopher.miller@example.com'],
        ['first_name' => 'Michelle', 'last_name' => 'Davis', 'email' => 'michelle.davis@example.com'],
        ['first_name' => 'Michael', 'last_name' => 'Rodriguez', 'email' => null],
        ['first_name' => 'Jessica', 'last_name' => 'Martinez', 'email' => 'jessica.martinez@example.com'],
        ['first_name' => 'Matthew', 'last_name' => 'Wilson', 'email' => 'matthew.wilson@example.com'],
        ['first_name' => 'Ashley', 'last_name' => 'Anderson', 'email' => 'ashley.anderson@example.com'],
        ['first_name' => 'Joshua', 'last_name' => 'Taylor', 'email' => null],
        ['first_name' => 'Amanda', 'last_name' => 'Thomas', 'email' => 'amanda.thomas@example.com'],
        ['first_name' => 'Daniel', 'last_name' => 'Moore', 'email' => 'daniel.moore@example.com'],
        ['first_name' => 'Stephanie', 'last_name' => 'Jackson', 'email' => 'stephanie.jackson@example.com'],
        ['first_name' => 'Andrew', 'last_name' => 'Martin', 'email' => 'andrew.martin@example.com'],
        ['first_name' => 'Jennifer', 'last_name' => 'Thompson', 'email' => 'jennifer.thompson@example.com'],
        ['first_name' => 'Steven', 'last_name' => 'White', 'email' => 'steven.white@example.com'],
        ['first_name' => 'Laura', 'last_name' => 'Lopez', 'email' => null],
    ];

    public function __invoke()
    {
        return $this->getUserEmails($this->users);
    }

    private function getUserEmails(array $users): array
    {
        return Collection::make($users)
            ->filter(fn(array $user): bool => $user['email'] !== null)
            ->map(fn(array $user) => $user['email'])
            ->toArray();
    }
}
