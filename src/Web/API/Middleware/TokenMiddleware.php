<?php

declare(strict_types=1);

namespace App\Web\API\Middleware;

use App\Common\Infrastructure\Request\HttpRequestContext;
use App\Modules\Accounts\Domain\User\UserException;
use App\Modules\Accounts\Domain\User\UserService;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\Accounts\User\Register\RegisterUserAction;
use App\Web\API\Action\Accounts\User\SignIn\SignInUserAction;
use DateInterval;
use DateTime;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use function get_class;
use function in_array;

final class TokenMiddleware implements EventSubscriberInterface
{
    protected array $allowedActions = [
        SignInUserAction::class,
        RegisterUserAction::class,
    ];

    public function __construct(
        private HttpRequestContext $httpRequestContext,
        private UserService $userService,
    ){}

    public function onKernelController(ControllerEvent $event): void
    {
        if ($event->getController() instanceof AbstractAction) {
        }
    }

    private function refreshToken(ControllerEvent $event): void
    {
        try {
            $event->getRequest()->cookies->set(
                '__ACCESS_TOKEN',
                $this->userService->refreshToken($this->httpRequestContext->getUserToken())
            );
        } catch (UserException $exception) {
            $this->setAuthenticationErrorResponse($event);
        }
    }

    private function setAuthenticationErrorResponse(ControllerEvent $event): void
    {
        $event->setController(static function (): Response {
            return new JsonResponse(['error' => 'Authentication error.'], Response::HTTP_FORBIDDEN);
        });
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        if ($event->getRequest()->cookies->has('__ACCESS_TOKEN')) {
            $cookie = Cookie::create(
                '__ACCESS_TOKEN',
                $event->getRequest()->cookies->get('__ACCESS_TOKEN'),
                (new DateTime())->add(new DateInterval('P6M')),
            );

            $event->getResponse()->headers->setCookie($cookie);
        }
    }

    #[ArrayShape([KernelEvents::CONTROLLER => "string", KernelEvents::RESPONSE => "string"])]
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }
}
