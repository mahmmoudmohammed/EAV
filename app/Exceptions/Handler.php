<?php

namespace App\Exceptions;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        CustomValidationException::class,
    ];

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (QueryException $e) {
            if (!config('app.debug')) {
                Log::channel('database')->error(message: $e->getMessage(), context:$this->onDebug($e));
                return response()->json([
                    'message' => 'An error occurred, please try again later...',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        });

        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if (!$request->is('api/*')) {
                return null;
            }
            if (!$request->route()) {
                return response()->json([
                    'message' => 'Url not found.',
                ], Response::HTTP_NOT_FOUND);
            }
            return response()->json([
                'message' => 'Record not found.',
            ], Response::HTTP_NOT_FOUND);
        });
    }
    protected function convertExceptionToArray(Throwable $e)
    {
        return config('app.debug') ? $this->onDebug($e): [
            'message' => $this->isHttpException($e) ? $e->getMessage() : 'An error occurred, please try again later.',
        ];
    }
    private function onDebug(Throwable $e):array
    {
        return [
            'message' => $e->getMessage(),
            'exception' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => collect($e->getTrace())->map(fn($trace) => \Arr::except($trace, ['args']))->all(),
        ] ;
    }
}
