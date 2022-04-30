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
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

/**
 * 400 BadRequestException
 * Class BadRequestExceptionSchema
 * @package App\OpenApi\Schemas\Exceptions
 */
class BadRequestExceptionSchema extends SchemaFactory implements Reusable
{
    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        return Schema::object('BadRequestException')
            ->properties(
                Schema::string('message')
                    ->description('エラーメッセージ')
                    ->example('不正なリクエストです')
                    ->nullable(),
                Schema::string('code')
                    ->description('エラーコード')
                    ->example('invalid_token'),
            )->required('message', 'code');
    }
}
