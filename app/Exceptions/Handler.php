<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     */
    public function report(Exception $exception): void
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     */
    public function render($request, Exception $exception)
    {
        $response = parent::render($request, $exception);

        if ($request->header('X-Inertia') && in_array($response->status(), [500, 503, 404, 403])) {
            flash('warning', 'Something went wrong.');

            return redirect()->route('dashboard');
        }

        if ($exception instanceof AuthorizationException) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized.'], 403);
            }

            flash('warning', 'Something went wrong.');

            return redirect()->route('dashboard');
        }

        return $response;
    }

    protected function whoopsHandler()
    {
        try {
            return app(\Whoops\Handler\HandlerInterface::class);
        } catch (\Illuminate\Contracts\Container\BindingResolutionException $e) {
            return (new \Illuminate\Foundation\Exceptions\WhoopsHandler)->forDebug();
        }
    }
}
