<?php
declare(strict_types=1);

namespace App\OpenApi\RequestBodies\Frontend\Auth;

use App\OpenApi\Schemas\Frontend\Auth\ResetPasswordParameterSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

/**
 * パスワードリセット
 * Class AdminResetPasswordRequestBody
 * @package App\OpenApi\RequestBodies\Frontend\Auth
 */
class ResetPasswordRequestBody extends RequestBodyFactory
{
    /**
     * @return RequestBody
     */
    public function build(): RequestBody
    {
        return RequestBody::create('ResetPassword')
            ->description('パスワードリセット')
            ->content(MediaType::json()->schema(ResetPasswordParameterSchema::ref()));
    }
}
