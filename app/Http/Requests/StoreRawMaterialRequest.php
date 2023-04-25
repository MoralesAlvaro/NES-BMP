<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRawMaterialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer'],
            'total' => ['required', 'float'],
            'quantity' => ['required', 'string', 'max:255'],
            'parts' => ['required', 'integer', 'min:1'],
            'cost' => ['required', 'float'],
            'active' => ['required', 'boolean']
        ];
    }
}
