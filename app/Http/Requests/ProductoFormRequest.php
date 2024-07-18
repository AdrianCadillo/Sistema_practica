<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           "nombre_producto" => "required",
           "stock" => ["required","numeric"],
           "precio" => ["required","numeric"]
        ];
    }

    public function messages()
    {
        return [
            "nombre_producto.required" => "Ingrese nombre producto...",
            "stock.required" => "Ingrese el stock...",
            "stock.numeric" => "El stock debe ser un número!",
            "precio.required" => "El precio es obligatorio!",
            "precio.numeric" => "El precio debe ser un número"
        ];
    }
}
