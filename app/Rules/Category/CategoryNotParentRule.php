<?php

declare(strict_types=1);

namespace App\Rules\Category;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Validation\Validator;

class CategoryNotParentRule implements ValidationRule, ValidatorAwareRule
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
     * Проверяет указанный атрибут.
     *
     * @param string $attribute Имя проверяемого атрибута.
     * @param mixed $value Значение атрибута.
     * @param Closure $fail Замыкание, вызываемое в случае ошибки валидации.
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->validator->getMessageBag()->has($attribute) || is_null($value)) {
            return;
        }

        $category = Category::find($this->existId);

        $query = Category::where('id', (int) $value)
            ->when($category, function ($query) use ($value, $category) {
                $parentCategory = Category::find($value);

                if ($parentCategory && !$parentCategory->isDescendantOf($category)) {
                    $query->where('id', $category->id);
                }

                return $query;
            });

        if ($query->exists()) {
            $fail(__('validation.not_parent'));
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
