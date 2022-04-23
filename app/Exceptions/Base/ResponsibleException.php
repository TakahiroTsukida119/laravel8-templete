<?php
declare(strict_types=1);

namespace App\Exceptions\Base;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ResponsibleException
 * @package App\Console\Base
 */
abstract class ResponsibleException extends Exception
{
    private string $errorCode;

    public function __construct(string $errorCode, string $message = null, Throwable $previous = null)
    {
        $this->errorCode = $errorCode;
        parent::__construct($message, 0, $previous);
    }

    /**
     * エラーコードを返します
     * @return string
     */
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    /**
     * json形式のレスポンスを返します
     * @param Request $request
     * @return JsonResponse
     */
    abstract protected function getJsonResponse(Request $request): JsonResponse;

    /**
     * jsonでのAPIリクエストでない場合のレスポンスを返します
     * @param Request $request
     * @return mixed
     */
    abstract protected function getHttpResponse(Request $request);

    /**
     * 例外処理のハンドリングするためのレスポンスを返します
     * @param Request $request
     * @return mixed
     */
    public function getResponse(Request $request): mixed
    {
        return $request->expectsJson()
            ? $this->getJsonResponse($request)
            : $this->getHttpResponse($request);
    }

}
