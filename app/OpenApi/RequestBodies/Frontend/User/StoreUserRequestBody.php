<?php
declare(strict_types=1);

namespace App\OpenApi\RequestBodies\Frontend\User;

use App\OpenApi\Schemas\Frontend\User\StoreUserParams;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

/**
 * ユーザー登録リクエスト
 * Class StoreUserRequestBody
 * @package App\OpenApi\RequestBodies\Frontend\User
 */
class StoreUserRequestBody extends RequestBodyFactory
{
    /**
     * @return RequestBody
     */
    public function build(): RequestBody
    {
        return RequestBody::create('StoreUser')
            ->description('ユーザー登録')
            ->content(MediaType::json()->schema(StoreUserParams::ref()));
    }
}
