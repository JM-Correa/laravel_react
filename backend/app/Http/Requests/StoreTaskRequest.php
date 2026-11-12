<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'  => ['required', 'string', 'max:45'],
            'detalle' => ['required', 'string'],
            'estatus' => ['sometimes', 'integer', 'in:0,1'],
        ];
    }
}