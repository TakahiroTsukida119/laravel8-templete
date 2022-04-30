<?php
declare(strict_types=1);

namespace App\OpenApi\Schemas\Exceptions;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

/**
 * Class TooManyRequestsExceptionSchema
 * @package App\OpenApi\Schemas\Exceptions
 */
class TooManyRequestsExceptionSchema extends SchemaFactory implements Reusable
{
    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        return Schema::object('TooManyRequestsException')
            ->properties(
                Schema::string('message')
                    ->description('エラーメッセージ')
                    ->example('リクエストがレートを超過しました')
                    ->nullable(),
                Schema::string('code')
                    ->description('エラーコード')
                    ->example('too_many_requests'),
                Schema::object('lockout')->properties(
                    Schema::integer('seconds')
                        ->description('秒数')
                        ->example(30),
                    Schema::integer('minutes')
                        ->description('分数')
                        ->example(4),
                )->required('seconds', 'minutes'),
            )->required('message', 'code', 'lockout');
    }
}
