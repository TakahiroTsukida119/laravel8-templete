<?php
declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class BadRequestException
 * @package App\Exceptions
 */
class BadRequestException extends Base\ResponsibleException
{
    public const CODE_INVALID_EMAIL = 'invalid_email';
    public const CODE_INVALID_TOKEN = 'invalid_token';

    /**
     * @inheritDoc
     */
    protected function getJsonResponse(Request $request): JsonResponse
    {
        return response()
            ->json([
                'message' => $this->message,
                'code'    => $this->getErrorCode()
            ], 400);
    }

    /**
     * @inheritDoc
     */
    protected function getHttpResponse(Request $request)
    {
        return redirect()
            ->back()
            ->withInput()
            ->with('alert_error', $this->message);
    }
}
