<?php
declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * Class TooManyRequestsException
 * @package App\Exceptions
 */
class TooManyRequestsException extends Base\ResponsibleException
{
    public const CODE_TOO_MANY_REQUESTS = 'too_many_requests';
    private int $seconds;
    private int $minutes;
    private string $strCode;

    public function __construct(
        int $minutes,
        int $seconds,
        string $message,
        string $code = self::CODE_TOO_MANY_REQUESTS,
        Throwable $previous = null
    )
    {
        parent::__construct('too_many_requests', $message, $previous);
        $this->seconds = $seconds;
        $this->minutes = $minutes;
        $this->strCode = $code;
    }

    /**
     * @inheritDoc
     */
    protected function getJsonResponse(Request $request): JsonResponse
    {
        return response()
            ->json([
                'message' => $this->message,
                'code' => $this->strCode,
                'lockout' => [
                    'seconds' => $this->seconds,
                    'minutes' => $this->minutes,
                ],
            ], Response::HTTP_TOO_MANY_REQUESTS);
    }

    /**
     * @inheritDoc
     */
    protected function getHttpResponse(Request $request)
    {
        return back()
            ->withInput()
            ->with('alert_error', $this->message);
    }
}
