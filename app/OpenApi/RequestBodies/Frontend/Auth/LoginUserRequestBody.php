<?php
declare(strict_types=1);

namespace App\OpenApi\RequestBodies\Frontend\Auth;

use App\OpenApi\Schemas\Frontend\Auth\LoginUserParameterSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

/**
 * ユーザーログインリクエスト
 * Class LoginUserRequestBody
 * @package App\OpenApi\RequestBodies
 */
class LoginUserRequestBody extends RequestBodyFactory
{
    /**
     * @return RequestBody
     */
    public function build(): RequestBody
    {
        return RequestBody::create('LoginUser')
            ->description('ログインパラメーター')
            ->content(MediaType::json()->schema(LoginUserParameterSchema::ref()));
    }
}
