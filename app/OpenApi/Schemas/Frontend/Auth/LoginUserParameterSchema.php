<?php
declare(strict_types=1);

namespace App\OpenApi\Schemas\Frontend\Auth;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

/**
 * Class LoginUserParameterSchema
 * @package App\OpenApi\Schemas
 */
class LoginUserParameterSchema extends SchemaFactory implements Reusable
{
    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        return Schema::object('LoginUserParameter')
            ->properties(
                Schema::string('email')
                    ->description('メールアドレス')
                    ->example('user1@example.com'),
                Schema::string('password')
                    ->description('パスワード')
                    ->example('password'),
            )->required('email', 'password');
    }
}
