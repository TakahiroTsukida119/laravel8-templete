<?php
declare(strict_types=1);

namespace App\Http\Requests\Backend\Auth;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class ResetRequest
 * @package App\Http\Requests\Backend\Auth
 */
class AdminResetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['token' => "string[]", 'email' => "string[]", 'password' => "string[]"])]
    public function rules(): array
    {
        return [
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'max:32', 'confirmed']
        ];
    }

    /**
     * トークン
     * @return string
     */
    public function getToken(): string
    {
        return $this->input('token');
    }

    /**
     * メールアドレス
     * @return string
     */
    public function getEmail(): string
    {
        return $this->input('email');
    }

    /**
     * パスワード
     * @return string
     */
    public function getPassword(): string
    {
        return $this->input('password');
    }

    /**
     * クレデンシャル
     * @return array
     */
    public function getCredential(): array
    {
        return $this->only(['email', 'token', 'password', 'password_confirmation']);
    }
}
