<?php
declare(strict_types=1);

namespace App\OpenApi\RequestBodies\Frontend\User;

use App\OpenApi\Schemas\Frontend\User\UpdateUserParams;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

/**
 * ユーザー更新リクエスト
 * Class UpdateUserRequestBody
 * @package App\OpenApi\RequestBodies\Frontend\User
 */
class UpdateUserRequestBody extends RequestBodyFactory
{
    /**
     * @return RequestBody
     */
    public function build(): RequestBody
    {
        return RequestBody::create('UpdateUser')
            ->description('ユーザー更新')
            ->content(MediaType::json()->schema(UpdateUserParams::ref()));
    }
}
