<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDashboardProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string|\Illuminate\Validation\Rules\Unique>>
     */
    public function rules(): array
    {
        /** @var Product $product */
        $product = $this->route('product');

        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price_sale' => ['required', 'numeric', 'min:0'],
            'product_code' => ['required', 'string', 'max:255', Rule::unique('products', 'product_code')->ignore($product->id)],
            'image' => ['nullable', 'image', 'max:3072'],
            'remove_image' => ['nullable', 'boolean'],
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

    protected function prepareForValidation(): void
    {
        if ($this->input('image') === '') {
            $this->merge(['image' => null]);
        }
    }
}
