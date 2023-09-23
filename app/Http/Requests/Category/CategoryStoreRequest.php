<?php

declare(strict_types=1);

namespace App\Http\Requests\Category;

use App\Rules\Category\CategoryUniqueCodeRule;
use App\Rules\ModelExistsRule;
use App\Rules\NullableIntegerRule;
use App\Rules\NullableStringRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CategoryStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', new CategoryUniqueCodeRule()],
            'description' => [new NullableStringRule(), 'max:1024'],
            'parent_id' => [new NullableIntegerRule(), new ModelExistsRule(table: 'categories', column: 'id')],
            'active' => ['required', 'boolean'],
        ];
    }
}
