<?php
declare(strict_types=1);

namespace App\OpenApi\RequestBodies\Frontend\Auth;

use App\OpenApi\Schemas\Frontend\Auth\ForgotPasswordParameterSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

/**
 * パスワードリセット
 * Class ForgotPasswordRequestBody
 * @package App\OpenApi\RequestBodies\Frontend\Auth
 */
class ForgotPasswordRequestBody extends RequestBodyFactory
{
    /**
     * @return RequestBody
     */
    public function build(): RequestBody
    {
        return RequestBody::create('ForgotPasswordRequest')
            ->description('パスワードリセットメールの送信')
            ->content(MediaType::json()->schema(ForgotPasswordParameterSchema::ref()));
    }
}
