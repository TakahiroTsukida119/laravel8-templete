<?php
declare(strict_types=1);

namespace App\Http\Requests\Frontend\Auth;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class AdminForgotRequest
 * @package App\Http\Requests\Frontend\Auth
 */
class ForgotRequest extends FormRequest
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
    #[ArrayShape(['email' => "string[]"])]
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
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
