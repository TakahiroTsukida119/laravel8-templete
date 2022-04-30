<?php
declare(strict_types=1);

namespace App\OpenApi\Responses\Exceptions;

use App\OpenApi\Schemas\Exceptions\TooManyRequestsExceptionSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

/**
 * TooManyRequestsException
 * Class TooManyRequestsResponse
 * @package App\OpenApi\Responses\Exceptions
 */
class TooManyRequestsResponse extends ResponseFactory
{
    /**
     * @return Response
     */
    public function build(): Response
    {
        return Response::tooManyRequests()
            ->content(MediaType::json()->schema(TooManyRequestsExceptionSchema::ref()));
    }
}
