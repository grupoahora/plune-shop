<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDashboardProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price_sale' => ['required', 'numeric', 'min:0'],
            'product_code' => ['required', 'string', 'max:255', 'unique:products,product_code'],
            'image' => ['nullable', 'image', 'max:3072'],
            'status' => ['required', 'boolean'],
            'discount_value' => ['nullable', 'numeric', 'min:0'],
            'discount_type' => ['nullable', 'in:percentage,fixed'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'description.required' => 'La descripción es obligatoria.',
            'price_sale.required' => 'El precio es obligatorio.',
            'product_code.required' => 'El código de producto es obligatorio.',
            'product_code.unique' => 'El código de producto ya está registrado.',
            'image.image' => 'Debes subir un archivo de imagen válido.',
            'image.max' => 'La imagen no puede superar los 3 MB.',
            'category_id.required' => 'La categoría es obligatoria.',
            'category_id.exists' => 'La categoría seleccionada no es válida.',
        ];
    }
}
