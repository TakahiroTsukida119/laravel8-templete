<?php
declare(strict_types=1);

namespace App\OpenApi\Schemas\Frontend\Auth;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

/**
 * アクセストークンデータ
 * Class LoginUserResponseSchema
 * @package App\OpenApi\Schemas\Auth
 */
class LoginUserResponseSchema extends SchemaFactory implements Reusable
{
    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        return Schema::object('LoginUserTokenData')
            ->description('アクセストークンのデータ')
            ->properties(
                Schema::string('access_token')
                    ->description('アクセストークン')
                    ->example('eyJ0eXAiOiJKV1QiLCJhbGciOiJFUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGkubG9jYWxob3N0XC92MVwvYXV0aFwvbG9naW4iLCJpYXQiOjE2MjkyNTkyNDksImV4cCI6MTY0OTk5NTI0OSwibmJmIjoxNjI5MjU5MjQ5LCJqdGkiOiJjS1l5aWhWMzVKNUpHMkhlIiwic3ViIjoiOTQyY2IxZTItOTk2My00NzM0LWJkYjEtYjhjNTQxOThhMmEyIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyIsImVtYWlsIjoidXNlcjVAZXhhbXBsZS5jb20ifQ.vWjxHvL_pJ54bTtB61dA3ZpOwzuiD1MA0m2IfTL9nNVXXjtIQBeq75bu7yNLd_vV1UZxQg-jocfW5yZdY1jVcQ'),

                Schema::string('token_type')
                    ->description('トークンタイプ')
                    ->example('Bearer'),

                Schema::integer('expires_in')
                    ->description('有効期限（単位：秒数）')
                    ->example(3600),
            )
            ->required('access_token', 'token_type', 'expires_in')
            ->readOnly();
    }
}
