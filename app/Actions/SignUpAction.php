<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Actions;

use Synthex\Phptherightway\Core\Model;
use Synthex\Phptherightway\Models\Invoice;
use Synthex\Phptherightway\Models\User;

final class SignUpAction extends Model
{
    public function __construct(
        private User $user,
        private Invoice $invoice,
    ) {
        parent::__construct();
    }

    public function register(array $userInfo, array $invoiceInfo): int
    {
        try {
            $this->db->beginTransaction();

            $userId = $this->user->create($userInfo['email'], $userInfo['name']);
            $invoiceId = $this->invoice->create($invoiceInfo['amount'], $userId);

            $this->db->commit();
        } catch (\Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            throw $e;
        }

        return $invoiceId;
    }
}
