<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Modules\Shared\Presentation\Exception\InputValidationException;
use Modules\Shared\Domain\Exception\DomainException;
use Modules\Shared\Domain\Service\LoggerInterface;
use Modules\Shared\Presentation\Http\JsonResponder;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $logger = app(LoggerInterface::class);

        $logException = function (Throwable $e, Request $request) use ($logger) {
            $logger->logException($e, [
                'url'       => $request->fullUrl(),
                'method'    => $request->method(),
                'ip'        => $request->ip(),
                'user_id'   => $request->user()?->id,
                'user_agent' => $request->userAgent(),
                'input'     => $request->except(['password', 'password_confirmation']),
            ]);
        };

        $exceptions->renderable(function (InputValidationException $e, Request $request) use ($logException) {
            $logException($e, $request);
            if ($request->expectsJson()) {
                $responder = app(JsonResponder::class);
                return $responder->validationError($e->errors);
            }
        });

        $exceptions->renderable(function (TokenMismatchException $e, Request $request) use ($logException) {
            $logException($e, $request);
            if ($request->inertia()) {
                return redirect('/login');
            }
            if ($request->expectsJson()) {
                $responder = app(JsonResponder::class);
                return $responder->error(
                    errorCode: 'token_mismatch',
                    status: 419,
                    messageKey: 'auth.token_mismatch'
                );
            }
        });

        $exceptions->renderable(function (DomainException $e, Request $request) use ($logException) {
            $logException($e, $request);
            if ($request->expectsJson()) {
                $responder = app(JsonResponder::class);
                return $responder->error(
                    errorCode: $e->getErrorCode()->value,
                    status: $e->getStatusCode(),
                    messageKey: 'errors.' . $e->getErrorCode()->value,
                    messageReplace: []
                );
            }
        });

        $exceptions->renderable(function (HttpExceptionInterface $e, Request $request) use ($logException) {
            $logException($e, $request);
            if ($request->expectsJson()) {
                $responder = app(JsonResponder::class);
                $status = $e->getStatusCode();
                $errorCode = match ($status) {
                    401 => 'unauthenticated',
                    403 => 'forbidden',
                    404 => 'not_found',
                    419 => 'token_mismatch',
                    429 => 'too_many_requests',
                    500 => 'server_error',
                    503 => 'service_unavailable',
                    default => 'http_error',
                };
                return $responder->error(
                    errorCode: $errorCode,
                    status: $status,
                    messageKey: "errors.{$errorCode}"
                );
            }
        });

        $exceptions->renderable(function (Throwable $e, Request $request) use ($logException) {
            $logException($e, $request);
            if ($request->expectsJson()) {
                $responder = app(JsonResponder::class);
                $status = $e instanceof HttpExceptionInterface ? $e->getStatusCode() : 500;
                $errorCode = $status === 500 ? 'server_error' : 'unknown_error';
                $messageKey = config('app.debug') ? null : "errors.{$errorCode}";
                $message = config('app.debug') ? $e->getMessage() : null;

                return $responder->error(
                    errorCode: $errorCode,
                    status: $status,
                    messageKey: $messageKey,
                    messageReplace: $message ? ['message' => $message] : []
                );
            }
        });
    })->create();
