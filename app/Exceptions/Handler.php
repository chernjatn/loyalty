<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            $exception = CustomValidationException::fromValidationException($exception);
        }

        if ($this->isHttpException($exception)) {
            $code = $exception->getStatusCode();
        } else {
            $code = $exception->getCode() > 100 && $exception->getCode() < 511
                ? $exception->getCode()
                : HttpResponse::HTTP_INTERNAL_SERVER_ERROR;
        }

        $data = ['message' => $exception->getMessage()];

        if ($exception instanceof BadRequestException) {
            $data += $exception->getData();

            return response($data, $code);
        }

        return parent::render($request, $exception);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
