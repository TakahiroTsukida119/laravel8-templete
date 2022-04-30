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
 * 404 NotFound
 * Class NotFoundExceptionSchema
 * @package App\OpenApi\Schemas\Exceptions
 */
class NotFoundExceptionSchema extends SchemaFactory implements Reusable
{
    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        return Schema::object('NotFoundException')
            ->properties(
                Schema::string('message')
                    ->description('エラー内容のメッセージ')
                    ->example('ページが見つかりません'),
                Schema::string('code')
                    ->description('エラーコード')
                    ->example('notfound'),
            )->required('message', 'code');
    }
}
