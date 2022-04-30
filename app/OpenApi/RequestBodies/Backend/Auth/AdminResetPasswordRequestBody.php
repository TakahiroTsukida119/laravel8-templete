<?php
declare(strict_types=1);

namespace App\OpenApi\RequestBodies\Backend\Auth;

use App\OpenApi\Schemas\Backend\Auth\AdminResetPasswordParams;
use App\OpenApi\Schemas\Frontend\Auth\ResetPasswordParameterSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

/**
 * パスワードリセット
 * Class AdminResetPasswordRequestBody
 * @package App\OpenApi\RequestBodies\Backend\Auth
 */
class AdminResetPasswordRequestBody extends RequestBodyFactory
{
    /**
     * @return RequestBody
     */
    public function build(): RequestBody
    {
        return RequestBody::create('AdminResetPasswordRequest')
            ->description('管理ユーザーパスワードリセット')
            ->content(MediaType::json()->schema(AdminResetPasswordParams::ref()));
    }
}
