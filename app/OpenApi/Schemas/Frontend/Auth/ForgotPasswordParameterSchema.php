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
 * Class ForgotPasswordParameterSchema
 * @package App\OpenApi\Schemas\Frontend\Request\Auth
 */
class ForgotPasswordParameterSchema extends SchemaFactory implements Reusable
{
    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        return Schema::object('ForgotPasswordParams')
            ->properties(
                Schema::string('email')
                    ->description('メールアドレス')
                    ->example('user1@example.com'),
            )->required('email');
    }
}
