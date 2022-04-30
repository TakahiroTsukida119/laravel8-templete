<?php
declare(strict_types=1);

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

/**
 * Class DefaultPostSuccessResponse
 * @package App\OpenApi\Schemas\Response
 */
class DefaultPostSuccessResponse extends ResponseFactory
{
    /**
     * @return Response
     */
    public function build(): Response
    {
        return Response::ok()
            ->content(MediaType::json()->schema(Schema::object()));
    }
}
