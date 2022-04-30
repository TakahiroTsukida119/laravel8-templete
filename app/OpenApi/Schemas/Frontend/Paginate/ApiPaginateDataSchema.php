<?php
declare(strict_types=1);

namespace App\OpenApi\Schemas\Frontend\Paginate;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

/**
 * ページネーション
 * Class ApiPaginateDataSchema
 * @package App\OpenApi\Schemas\Frontend\Response\Paginate
 */
class ApiPaginateDataSchema extends SchemaFactory implements Reusable
{
    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        return Schema::object('Paginate')
            ->properties(
                Schema::integer('current_page')
                    ->description('現在のページ数')
                    ->example(1),
                Schema::integer('total_page')
                    ->description('総のページ数')
                    ->example(5),
                Schema::integer('total_count')
                    ->description('総件数')
                    ->example(95),
            )->required(
                'current_page',
                'total_page',
                'total_count',
            );
    }
}
