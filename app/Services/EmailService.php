<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Services;

use Symfony\Component\Mailer\MailerInterface;
use Synthex\Phptherightway\Enums\EmailStatus;
use Synthex\Phptherightway\Models\Email;

class EmailService
{
    public function __construct(protected Email $emailModel, protected MailerInterface $mailer)
    {
    }

    public function sendQueuedEmails(): void
    {
        $emails = $this->emailModel->getEmailsByStatus(EmailStatus::Queue);

        foreach ($emails as $email) {
            $meta = json_decode($email->meta, true);

            $emailMessage = (new \Symfony\Component\Mime\Email())
                ->from($meta['from'])
                ->to($meta['to'])
                ->subject($email->subject)
                ->text($email->text_body)
                ->html($email->html_body);

            $this->mailer->send($emailMessage);

            $this->emailModel->markEmailSent($email->id);
        }
    }
}
