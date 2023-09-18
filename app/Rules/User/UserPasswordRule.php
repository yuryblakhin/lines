<?php

declare(strict_types=1);

namespace App\Rules\User;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserPasswordRule implements ValidationRule
{
    /**
     * Проверка атрибута.
     *
     * @param string $attribute Имя проверяемого атрибута.
     * @param mixed $value Значение атрибута.
     * @param Closure $fail Замыкание, вызываемое при ошибке валидации.
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^(?=.*[a-z])/u', $value)) {
            $fail(__('validation.password.lowercase'));
        }

        if (!preg_match('/^(?=.*[A-Z])/u', $value)) {
            $fail(__('validation.password.uppercase'));
        }

        // Check if the value contains at least one digit
        if (!preg_match('/^(?=.*[0-9])/u', $value)) {
            $fail(__('validation.password.numbers'));
        }

        // Check if the value contains at least one special character
        if (!preg_match('/(?=.*[\~\!\@\#\$\%\^\&\*\_\-\+\=\`\|\(\)\{\}\[\]\:\;\'\<\>\,\.\?\;"])/u', $value)) {
            $fail(__('validation.password.symbols'));
        }

        // Check if the value doesn't contain any whitespace
        if (!preg_match('/^\S*$/u', $value)) {
            $fail(__('validation.password.whitespace'));
        }

        // Check if the value contains only Latin characters, digits, and allowed special characters
        if (!preg_match('/^[a-zA-Z0-9\~\!\@\#\$\%\^\&\*\_\-\+\=\`\|\(\)\{\}\[\]\:\;\'\<\>\,\.\?\;"\s]*$/u', $value)) {
            $fail(__('validation.password.only_latin'));
        }
    }
}
