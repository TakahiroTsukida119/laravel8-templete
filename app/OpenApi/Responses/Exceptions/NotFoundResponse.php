<?php
declare(strict_types=1);

namespace App\OpenApi\Responses\Exceptions;

use App\OpenApi\Schemas\Exceptions\ForbiddenExceptionSchema;
use App\OpenApi\Schemas\Exceptions\NotFoundExceptionSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

/**
 * 404 NotFound
 * Class NotFoundResponse
 * @package App\OpenApi\Responses\Exceptions
 */
class NotFoundResponse extends ResponseFactory
{
    /**
     * @return Response
     */
    public function build(): Response
    {
        return Response::notFound()
            ->content(MediaType::json()->schema(NotFoundExceptionSchema::ref()));
    }
}
