<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Rules\NullableStringRule;
use App\Rules\User\UserUniqueEmailRule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
    public function rules(): array
    {
        return [
            'email' => ['sometimes', 'string', 'max:255', 'email', new UserUniqueEmailRule(existId: $this->route('user')),
            ],
            'first_name' => ['sometimes', new NullableStringRule(), 'max:255'],
            'last_name' => ['sometimes', new NullableStringRule(), 'max:255'],
        ];
    }
}
