<?php
declare(strict_types=1);

namespace App\ViewModels\Backend\Auth;

use App\ViewModels\Base\ViewModel;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class AdminLoginViewModel アクセストークンのViewModel
 * @package App\ViewModels\Backend
 */
class AdminLoginViewModel extends ViewModel
{
    private string $token;

    /**
     * AdminLoginViewModel constructor.
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
            'expires_in' => auth('admin')->factory()->getTTL() * 60
        ];
    }
}
