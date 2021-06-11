<?php

declare(strict_types=1);

namespace App\Web\API\Middleware;

use App\Modules\Accounts\Application\User\LogicException as AccountsModuleLogicException;
use App\Modules\Accounts\Application\User\NotFoundException as AccountsModuleNotFoundException;
use App\Modules\Accounts\Application\User\ValidationException as AccountsModuleValidationException;
use App\Web\API\DomainErrorResponse;
use App\Web\API\ValidationErrorResponse;
use Assert\LazyAssertionException;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Throwable;

final class ErrorHandlerMiddleware implements EventSubscriberInterface
{
	private const VALIDATION_ERROR_TYPE = 'ValidationError';
	private const DOMAIN_ERROR_TYPE = 'DomainError';

    /**
     * @throws Throwable
     */
    public function onKernelException(ExceptionEvent $event): void
    {
    	if (str_contains($event->getRequest()->getPathInfo(), '/api/')) {
			$exception = $event->getThrowable();

			// Modules exceptions handler
			if ($exception instanceof HandlerFailedException) {
				$exception = $exception->getPrevious();
				$response = [
					'type' => self::DOMAIN_ERROR_TYPE,
					'errors' => DomainErrorResponse::getResponse($exception),
				];

				$statusCode = match ($exception::class) {
					AccountsModuleValidationException::class => Response::HTTP_BAD_REQUEST,
					AccountsModuleLogicException::class => Response::HTTP_CONFLICT,
					AccountsModuleNotFoundException::class => Response::HTTP_NOT_FOUND,
					default => throw $exception,
				};

				$event->setResponse(
					new JsonResponse(
						$response,
						$statusCode
					)
				);
			}

			// request validation exceptions handler
			if ($exception instanceof LazyAssertionException) {
				$response = [
					'type' => self::VALIDATION_ERROR_TYPE,
					'errors' => ValidationErrorResponse::getResponse(...$exception->getErrorExceptions()),
				];

				$event->setResponse(
					new JsonResponse(
						$response,
						Response::HTTP_BAD_REQUEST
					)
				);
			}
		}
    }

    #[ArrayShape([KernelEvents::EXCEPTION => "string"])]
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
