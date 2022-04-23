<?php
declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\Base\ResponsibleException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $exception, Request $request) {
            $e = $this->prepareException($exception);

            if ($exception instanceof ResponsibleException) {
                return $exception->getResponse($request);
            }
            if ($e instanceof NotFoundHttpException && $request->expectsJson()) {
                return $this->notFound();
            }
            if ($e instanceof HttpResponseException) {
                return $e->getResponse();
            }
            if ($e instanceof ValidationException) {
                return $this->convertValidationExceptionToResponse($e, $request);
            }
            if ($e instanceof AuthenticationException) {
                return $this->unauthenticated($request, $e);
            }
            if ($e instanceof TooManyRequestsHttpException) {
                return $this->tooManyRequests();
            }

            return $request->expectsJson()
                ? $this->prepareJsonResponse($request, $exception)
                : $this->prepareResponse($request, $exception);
        });
    }

    /**
     * @inheritDoc
     */
    protected function unauthenticated($request, AuthenticationException $exception): JsonResponse|Response|RedirectResponse
    {
        return $this->shouldReturnJson($request, $exception)
            ? response()->json([
                'message' => $exception->getMessage(),
                'code' => 'authentication_failed,'
            ], 401)
            : redirect()->guest($exception->redirectTo() ?? route('admin.login'));
    }

    /**
     * @return JsonResponse
     */
    private function notFound(): JsonResponse
    {
        return response()->json([
            'message' => __('exception.not_found'),
            'code' => 'not_found',
        ], 404);
    }

    /**
     * @return JsonResponse
     */
    private function tooManyRequests(): JsonResponse
    {
        return response()->json([
            'message' => __('auth.throttle'),
            'code' => 'too_many_requests',
        ], 429);
    }
}
