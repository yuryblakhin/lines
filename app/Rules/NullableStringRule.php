<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NullableStringRule implements ValidationRule
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
        if (!is_string($value) && !is_null($value)) {
            $fail(__('validation.nullable_string'));
        }
    }
}
