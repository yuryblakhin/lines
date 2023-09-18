<?php

declare(strict_types=1);

namespace App\Http\Requests\Category;

use App\Rules\Category\CategoryNotParentRule;
use App\Rules\Category\CategoryUniqueCodeRule;
use App\Rules\ModelExistsRule;
use App\Rules\NullableIntegerRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CategoryUpdateRequest extends FormRequest
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
        if ($this->has('code')) {
            $this->merge(['code' => Str::slug($this->input('code'))]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'min:1', 'max:128'],
            'code' => ['sometimes', 'min:1', 'max:128', new CategoryUniqueCodeRule(existId: $this->route('category'))],
            'description' => ['sometimes', 'max:1024'],
            'parent_id' => [new NullableIntegerRule(), new ModelExistsRule(table: 'categories', column: 'id'), new CategoryNotParentRule(existId: $this->route('category'))],
        ];
    }
}
