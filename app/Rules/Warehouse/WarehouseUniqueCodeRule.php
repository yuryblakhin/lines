<?php

declare(strict_types=1);

namespace App\Rules\Warehouse;

use App\Models\Warehouse;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Validation\Validator;

class WarehouseUniqueCodeRule implements ValidationRule, ValidatorAwareRule
{
    /**
     * Экземпляр Validator.
     *
     * @var Validator
     */
    protected Validator $validator;

    /**
     * ID, который нужно игнорировать во время проверки наличия.
     *
     * @var mixed|null
     */
    protected mixed $existId;

    /**
     * Создает новый экземпляр правила валидации.
     *
     * @param mixed|null $existId ID, который нужно игнорировать во время проверки наличия.
     * @return void
     */
    public function __construct(mixed $existId = null)
    {
        $this->existId = $existId;
    }

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
        if ($this->validator->getMessageBag()->has($attribute)) {
            return;
        }

        $query = Warehouse::whereRaw('LOWER(code) = ?', [mb_strtolower((string) $value)])
            ->when($this->existId, function ($query) {
                return $query->where('id', '<>', $this->existId);
            });

        if ($query->exists()) {
            $fail(__('validation.unique'));
        }
    }

    /**
     * Установка текущего экземпляра валидатора.
     *
     * @param Validator $validator Экземпляр валидатора.
     * @return static
     */
    public function setValidator(Validator $validator): static
    {
        $this->validator = $validator;

        return $this;
    }
}
