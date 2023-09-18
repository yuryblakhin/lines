<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;

class ModelExistsRule implements ValidationRule, ValidatorAwareRule
{
    /**
     * Экземпляр Validator.
     *
     * @var Validator
     */
    protected Validator $validator;

    /**
     * Имя таблицы для проверки на существование.
     *
     * @var string
     */
    protected string $table;

    /**
     * Имя столбца для проверки на существование.
     *
     * @var string
     */
    protected string $column;

    /**
     * ID, который нужно игнорировать во время проверки наличия.
     *
     * @var mixed|null
     */
    protected mixed $existId;

    /**
     * Создает новый экземпляр правила валидации.
     *
     * @param string $table Имя таблицы для проверки на существование.
     * @param string $column Имя столбца для проверки на существование.
     * @param mixed|null $existId ID, который нужно игнорировать во время проверки наличия.
     * @return void
     */
    public function __construct(string $table, string $column, mixed $existId = null)
    {
        $this->table = $table;
        $this->column = $column;
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
        if ($this->validator->getMessageBag()->has($attribute) || is_null($value)) {
            return;
        }

        $query = DB::table($this->table)
            ->where($this->column, $value)
            ->when($this->existId, function ($query) {
                return $query->where('id', '<>', $this->existId);
            });

        if ($query->exists()) {
            $fail(__('validation.exists'));
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
