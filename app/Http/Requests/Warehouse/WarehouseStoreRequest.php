<?php

declare(strict_types=1);

namespace App\Http\Requests\Warehouse;

use App\Rules\Warehouse\WarehouseUniqueCodeRule;
use Illuminate\Foundation\Http\FormRequest;

class WarehouseStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', new WarehouseUniqueCodeRule()],
            'address' => ['string', 'max:1024'],
            'phones' => ['array'],
            'phones.*' => ['string'],
            'active' => ['required', 'boolean'],
        ];
    }
}
