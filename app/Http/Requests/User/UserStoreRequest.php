<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Rules\ModelExistsRule;
use App\Rules\NullableStringRule;
use App\Rules\User\UserPasswordRule;
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'min:1',
                'max:60',
                'email',
                new ModelExistsRule(table: 'users', column: 'email'),
            ],
            'password' => ['required', 'min:8', 'max:50', new UserPasswordRule()],
            'first_name' => [new NullableStringRule(), 'max:60'],
            'last_name' => [new NullableStringRule(), 'max:60'],
        ];
    }
}
