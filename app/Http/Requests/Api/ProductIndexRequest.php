<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ProductIndexRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'per_page' => 'sometimes|integer|min:1|max:50',
            'page' => 'sometimes|integer|min:1'
        ];
    }
}
