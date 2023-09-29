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
            'code' => ['required', 'string', 'max:255', new ProductUniqueCodeRule()],
            'sku_owner' => [new NullableStringRule(), 'max:255'],
            'description' => [new NullableStringRule(), 'max:1024'],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'images' => ['array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'categories' => ['required', 'array'],
            'categories.*' => [new ModelExistsRule(table: 'categories', column: 'id')],
            'active' => ['required', 'boolean'],
        ];
    }
}
