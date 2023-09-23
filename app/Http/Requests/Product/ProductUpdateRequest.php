<?php

declare(strict_types=1);

namespace App\Http\Requests\Product;

use App\Rules\ModelExistsRule;
use App\Rules\NullableStringRule;
use App\Rules\Product\ProductUniqueCodeRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ProductUpdateRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:255'],
            'code' => ['sometimes', 'string', 'max:255', new ProductUniqueCodeRule(existId: $this->route('product'))],
            'description' => ['sometimes', new NullableStringRule(), 'max:1024'],
            'image' => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'images' => ['sometimes', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'categories' => ['sometimes', 'array'],
            'categories.*' => [new ModelExistsRule(table: 'categories', column: 'id')],
            'active' => ['sometimes', 'boolean'],
        ];
    }
}
