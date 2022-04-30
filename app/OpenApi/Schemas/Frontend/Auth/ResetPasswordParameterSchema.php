<?php
declare(strict_types=1);

namespace App\OpenApi\Schemas\Frontend\Auth;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

/**
 * パスワードリセット
 * Class AdminResetPasswordParams
 * @package App\OpenApi\Schemas\Frontend\Request\Auth
 */
class ResetPasswordParameterSchema extends SchemaFactory implements Reusable
{
    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        return Schema::object('ResetPasswordParameter')
            ->properties(
                Schema::string('token')
                    ->description('認証用一時トークン')
                    ->example('52354fbd129c529a379656dd8b77661af835aaaf9ed11def9c1c70f6e0821601'),
                Schema::string('email')
                    ->description('メールアドレス')
                    ->example('user1@example.com'),
                Schema::string('password')
                    ->description('パスワード')
                    ->example('password'),
                Schema::string('password_confirmation')
                    ->description('パスワード確認用')
                    ->example('password'),
            )->required('token', 'email', 'password', 'password_confirmation');
    }
}
