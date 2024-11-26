<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = ['current_password', 'password', 'password_confirmation'];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        // Handle 403 Forbidden errors
        if ($exception instanceof AuthorizationException) {
            return response()->view('layouts.errors.403', [], 403);
        }

        // Handle 404 Not Found errors
        if ($exception instanceof HttpException && $exception->getStatusCode() === 404) {
            return response()->view('layouts.errors.404', [], 404);
        }

        // Handle 500 Server errors
        if ($exception instanceof HttpException && $exception->getStatusCode() === 500) {
          \Log::error('500 Internal Server Error', ['exception' => $exception]);

            return response()->view('layouts.errors.500', [], 500);
        }

        // Handle 419 Page Expired errors
        if ($exception instanceof HttpException && $exception->getStatusCode() === 419) {
            return response()->view('layouts.errors.419', [], 419);
        }

        // Default handling for other exceptions
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson() ? response()->json(['message' => 'Unauthenticated.'], 401) : redirect()->guest(route('page-login'));
    }
}
