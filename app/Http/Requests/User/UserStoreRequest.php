<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Rules\NullableStringRule;
use App\Rules\User\UserPasswordRule;
use App\Rules\User\UserUniqueEmailRule;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'active' => $this->has('active'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'max:255', 'email', new UserUniqueEmailRule()],
            'password' => ['required', 'string', 'max:255', new UserPasswordRule()],
            'first_name' => [new NullableStringRule(), 'max:255'],
            'last_name' => [new NullableStringRule(), 'max:255'],
            'active' => ['required', 'boolean'],
        ];
    }
}
