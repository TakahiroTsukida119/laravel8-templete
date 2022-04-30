<?php
declare(strict_types=1);

namespace App\OpenApi\Responses\Backend\Auth;

use App\OpenApi\Schemas\Backend\Auth\LoginAdminResponseSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

/**
 * ログインレスポンス
 * Class LoginAdminResponse
 * @package App\OpenApi\Responses
 */
class LoginAdminResponse extends ResponseFactory
{
    /**
     * @return Response
     */
    public function build(): Response
    {
        return Response::ok()
            ->content(MediaType::json()->schema(LoginAdminResponseSchema::ref()));
    }
}
