<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\Mail\SendConfirmationEmail;

use App\Common\Application\Command\CommandHandler;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

final class SendRegisterConfirmationEmailHandler implements CommandHandler
{
    private const SUBJECT = 'Confirm event registration';

    public function __construct(private MailerInterface $mailer, private RouterInterface $router){}

    public function __invoke(SendRegisterConfirmationEmailCommand $command): void
    {
        $email = (new TemplatedEmail())
            ->to($command->email)
            ->subject(self::SUBJECT)
            ->htmlTemplate('@accounts.email/email-confirmation.html.twig')
            ->context([
                'fullName' => sprintf('%s %s', $command ->firstName, $command->lastName),
                'username' => $command->username,
                'confirmationUrl' => $this->router->generate(
                    'api.v1.accounts.confirm-email',
                    [
                        'token' => $command->confirmationToken
                    ],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
            ]);

        $this->mailer->send($email);
    }
}
