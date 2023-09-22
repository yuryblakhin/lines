<?php

declare(strict_types=1);

namespace App\Http\Requests\Product;

use App\Rules\ModelExistsRule;
use App\Rules\NullableStringRule;
use App\Rules\Product\ProductUniqueCodeRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ProductStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', new ProductUniqueCodeRule()],
            'description' => [new NullableStringRule(), 'max:1024'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'images' => ['array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'categories' => ['required', 'array'],
            'categories.*' => [new ModelExistsRule(table: 'categories', column: 'id')],
        ];
    }
}
