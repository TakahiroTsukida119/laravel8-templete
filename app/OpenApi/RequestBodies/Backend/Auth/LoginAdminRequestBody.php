<?php
declare(strict_types=1);

namespace App\OpenApi\RequestBodies\Backend\Auth;

use App\OpenApi\Schemas\Backend\Auth\LoginAdminParameterSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

/**
 * 管理ユーザーログインリクエスト
 * Class LoginAdminRequestBody
 * @package App\OpenApi\RequestBodies
 */
class LoginAdminRequestBody extends RequestBodyFactory
{
    /**
     * @return RequestBody
     */
    public function build(): RequestBody
    {
        return RequestBody::create('LoginAdminRequest')
            ->description('管理ユーザーログインパラメーター')
            ->content(MediaType::json()->schema(LoginAdminParameterSchema::ref()));
    }
}
