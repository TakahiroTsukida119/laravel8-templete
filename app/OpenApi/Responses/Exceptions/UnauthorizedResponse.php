<?php
declare(strict_types=1);

namespace App\OpenApi\Responses\Exceptions;

use App\OpenApi\Schemas\Exceptions\UnauthorizedExceptionSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

/**
 * Class UnauthorizedResponse 401 AuthenticationException
 * @package App\OpenApi\Responses\Exceptions
 */
class UnauthorizedResponse extends ResponseFactory
{
    /**
     * @return Response
     */
    public function build(): Response
    {
        return Response::unauthorized()
            ->content(MediaType::json()->schema(UnauthorizedExceptionSchema::ref()));
    }
}
