<?php
declare(strict_types=1);

namespace App\ViewModels\Frontend\Auth;

use App\ViewModels\Base\ViewModel;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class AccessTokenViewModel アクセストークンのViewModel
 * @package App\ViewModels\Frontend
 */
class AccessTokenViewModel extends ViewModel
{
    private string $token;

    /**
     * AccessTokenViewModel constructor.
     * @param string $token ログイン時に発行されるアクセストークン（jwt）
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }


    /**
     * @inheritDoc
     */
    #[ArrayShape(['access_token' => "string", 'token_type' => "string", 'expires_in' => "float|int"])]
    public function toMap(): array
    {
        return [
            'access_token' => $this->token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ];
    }
}
