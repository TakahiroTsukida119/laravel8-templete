<?php
declare(strict_types=1);

namespace App\OpenApi\Schemas\Frontend\User;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

/**
 * ユーザー登録リクエストスキーマ
 * Class StoreUserParams
 * @package App\OpenApi\Schemas\Frontend\Request\User
 */
class StoreUserParams extends SchemaFactory implements Reusable
{
    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        return Schema::object('StoreUserParams')
            ->description('ユーザー登録リクエストパラメーター')
            ->properties(
                Schema::string('name')
                    ->description('氏名')
                    ->example('鈴木一郎'),
                Schema::string('email')
                    ->description('メールアドレス')
                    ->example('user1@example.com'),
            )->required(
                'name',
                'email',
            );
    }
}
