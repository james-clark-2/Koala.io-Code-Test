<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

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

        $this->renderable(
            fn (ValidationException $e) =>
                response()->json([
                    'errors' => $e->errors()
                ], $e->status)
        );

        $this->renderable(
            function (NotFoundHttpException $e) {
                if ($e->getPrevious() instanceof ModelNotFoundException) {
                    $className = explode('\\', $e->getPrevious()->getModel());
                    $message = ucfirst(end($className)) . ' not found.';

                    return response()->json([
                        'errors' => $message
                    ], 404);
                }
            }
        );
    }
}
