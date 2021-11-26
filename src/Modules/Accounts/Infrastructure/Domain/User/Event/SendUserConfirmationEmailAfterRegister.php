<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\User\Event;

use App\Common\Application\Event\EventHandler;
use App\Modules\Accounts\Domain\User\Event\UserWasRegistered;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

final class SendUserConfirmationEmailAfterRegister implements EventHandler
{
    private const SUBJECT = 'Confirm event registration';

    public function __construct(private MailerInterface $mailer, private RouterInterface $router){}

    public function __invoke(UserWasRegistered $event): void
    {
        $email = (new TemplatedEmail())
            ->to($event->getEmail())
            ->subject(self::SUBJECT)
            ->htmlTemplate('@accounts.email/email-confirmation.html.twig')
            ->context([
                'fullName' => sprintf('%s %s', $event->getFirstName(), $event->getLastName()),
                'username' => $event->getUsername(),
                'confirmationUrl' => $this->router->generate(
                    'api.v1.accounts.confirm-email',
                    [
                        'token' => $event->getConfirmationToken()
                    ],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
            ]);

        $this->mailer->send($email);
    }
}
