<?php
declare(strict_types=1);

namespace App\OpenApi\RequestBodies\Backend\Auth;

use App\OpenApi\Schemas\Backend\Auth\AdminForgotPasswordParams;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

/**
 * パスワードリセット
 * Class AdminForgotPasswordRequestBody
 * @package App\OpenApi\RequestBodies\Backend\Auth
 */
class AdminForgotPasswordRequestBody extends RequestBodyFactory
{
    /**
     * @return RequestBody
     */
    public function build(): RequestBody
    {
        return RequestBody::create('AdminForgotPasswordRequest')
            ->description('管理ユーザーパスワードリセットメールの送信')
            ->content(MediaType::json()->schema(AdminForgotPasswordParams::ref()));
    }
}
