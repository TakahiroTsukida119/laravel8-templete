<?php
declare(strict_types=1);

namespace App\OpenApi\Responses\Frontend\Auth;

use App\OpenApi\Schemas\Frontend\Auth\LoginUserResponseSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

/**
 * ログインレスポンス
 * Class LoginUserResponse
 * @package App\OpenApi\Responses
 */
class LoginUserResponse extends ResponseFactory
{
    /**
     * @return Response
     */
    public function build(): Response
    {
        return Response::ok()
            ->content(MediaType::json()->schema(LoginUserResponseSchema::ref()));
    }
}
