<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        // Define the response
        $response = [
            'message' => $e->getMessage()
        ];

        if ($e instanceof ValidationException && !empty($e->errors())) {
            $response['message'] = "Validation exception!";
            $response['messages'] = array_map(function ($value) {
                return $value[0];
            }, $e->errors());
        }

        // If the app is in debug mode
        if (env('APP_DEBUG', config('app.debug', false))) {
            // Add the exception class name, message and stack trace to response
            $response['exception'] = get_class($e); // Reflection might be better here
        }

        $status = (is_numeric($e->getCode()) && $e->getCode() > 0) ? $e->getCode() : 400;

        // Return a JSON response with the response array and status code
        return response()->json($response, $status);
    }
}
