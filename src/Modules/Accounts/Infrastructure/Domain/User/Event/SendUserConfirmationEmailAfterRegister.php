<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\User\Event;

use App\Common\Application\Event\EventHandler;
use App\Modules\Accounts\Domain\User\Event\UserWasRegistered;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class SendUserConfirmationEmailAfterRegister implements EventHandler
{
    public function __construct(private MailerInterface $mailer){}

    public function __invoke(UserWasRegistered $event): void
    {
        $email = (new TemplatedEmail())
            ->to($event->getEmail())
            ->subject('Email confirmation')
            ->htmlTemplate('@accounts.email/email-confirmation.html.twig')
            ->context([]);

        $this->mailer->send($email);
    }
}
