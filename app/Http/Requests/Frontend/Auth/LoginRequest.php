<?php
declare(strict_types=1);

namespace App\Http\Requests\Frontend\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class LoginRequest
 * @package App\Http\Requests\Frontend\Auth
 */
class LoginRequest extends FormRequest
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
    #[ArrayShape(['email' => "string[]", 'password' => "string[]"])]
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255']
        ];
    }

    /**
     * データの形式が正しいかチェックします
     * @return bool
     */
    public function isValid(): bool
    {
        return Validator::make($this->all(), $this->rules())
            ->passes();
    }

    /**
     * 入力されたパスワード
     * @return string
     */
    public function getPassword(): string
    {
        return $this->input('password');
    }

    /**
     * メールアドレス
     * @return string
     */
    public function getEmail(): string
    {
        return $this->input('email');
    }
}
