<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'material_id'   => 'required|exists:materials,id',
            'size_id'       => 'required|exists:sizes,id',
            'lamination_id' => 'nullable|exists:laminations,id',
            'price'         => 'required|numeric|min:0',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
