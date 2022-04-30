<?php
declare(strict_types=1);

namespace App\OpenApi\Responses\Exceptions;

use App\OpenApi\Schemas\Exceptions\ForbiddenExceptionSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

/**
 * 403 権限エラー Forbidden
 * Class ForbiddenResponse
 * @package App\OpenApi\Responses\Exceptions
 */
class ForbiddenResponse extends ResponseFactory
{
    /**
     * @return Response
     */
    public function build(): Response
    {
        return Response::forbidden()
            ->content(MediaType::json()->schema(ForbiddenExceptionSchema::ref()));
    }
}
