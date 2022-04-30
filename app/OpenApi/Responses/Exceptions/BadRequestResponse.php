<?php
declare(strict_types=1);

namespace App\OpenApi\Responses\Exceptions;

use App\OpenApi\Schemas\Exceptions\BadRequestExceptionSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

/**
 * Class BadRequestResponse
 * @package App\OpenApi\Responses\Exceptions
 */
class BadRequestResponse extends ResponseFactory
{
    /**
     * @return Response
     */
    public function build(): Response
    {
        return Response::badRequest()
            ->content(MediaType::json()->schema(BadRequestExceptionSchema::ref()));
    }
}
