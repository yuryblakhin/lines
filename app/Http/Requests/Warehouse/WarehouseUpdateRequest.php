<?php

declare(strict_types=1);

namespace App\Http\Requests\Warehouse;

use App\Rules\NullableStringRule;
use App\Rules\Warehouse\WarehouseUniqueCodeRule;
use Illuminate\Foundation\Http\FormRequest;

class WarehouseUpdateRequest extends FormRequest
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
            'code' => ['sometimes', 'string', 'max:255', new WarehouseUniqueCodeRule(existId: $this->route('warehouse'))],
            'address' => ['sometimes', new NullableStringRule(),  'max:1024'],
            'phones' => ['sometimes', 'array'],
            'phones.*' => ['string'],
            'active' => ['sometimes', 'boolean'],
        ];
    }
}
