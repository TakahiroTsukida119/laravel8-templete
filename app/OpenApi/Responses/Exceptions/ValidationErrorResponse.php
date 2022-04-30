<?php
declare(strict_types=1);

namespace App\OpenApi\Responses\Exceptions;

use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

/**
 * バリデーションエラー
 * Class ValidationErrorResponse
 * @package App\OpenApi\Responses
 */
class ValidationErrorResponse extends ResponseFactory
{
    /**
     * @return Response
     * @throws InvalidArgumentException
     */
    public function build(): Response
    {
        $res = Schema::object()->title('ValidationErrorResponse')
            ->properties(
                Schema::object('errors')->title('ValidationErrors')->properties(
                    Schema::array('keys')
                        ->items(
                            Schema::string('key')
                                ->description('エラーの対象リクエストキー名')
                                ->example('email'),
                        )
                        ->example(['name', 'email']),
                    Schema::array('values')
                        ->items(
                            Schema::string('value')
                                ->description('エラーの内容')
                                ->example('メールアドレスは必須です'),
                        )
                        ->example(['名前は255文字以内です', 'メールアドレスは必須です']),
                )->required('keys', 'values')
            )
            ->required('errors');

        return Response::unprocessableEntity()
            ->content(MediaType::json()->schema($res));
    }
}
