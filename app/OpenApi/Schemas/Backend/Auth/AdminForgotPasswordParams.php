<?php
declare(strict_types=1);

namespace App\OpenApi\Schemas\Backend\Auth;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

/**
 * パスワードリセット
 * Class ForgotPasswordParameterSchema
 * @package App\OpenApi\Schemas\Backend\Request\Auth
 */
class AdminForgotPasswordParams extends SchemaFactory implements Reusable
{
    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        return Schema::object('AdminForgotPasswordParams')
            ->properties(
                Schema::string('email')
                    ->description('メールアドレス')
                    ->example('admin1@example.com'),
            )->required('email');
    }
}
