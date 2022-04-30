<?php
declare(strict_types=1);

namespace App\OpenApi\Schemas\Exceptions;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Illuminate\Auth\AuthenticationException;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

/**
 * AuthenticationException
 * Class UnauthorizedExceptionSchema
 * @package App\OpenApi\Schemas\Exceptions
 */
class UnauthorizedExceptionSchema extends SchemaFactory implements Reusable
{
    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        return Schema::object('UnauthorizedException')
            ->properties(
                Schema::string('message')
                    ->description('エラー内容のメッセージ')
                    ->example('メールアドレスまたはパスワードが違います'),
                Schema::string('code')
                    ->description('エラーコード')
                    ->example('authentication_failed'),
            )->required('message', 'code');

    }
}
