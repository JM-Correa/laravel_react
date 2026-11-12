<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'  => ['sometimes', 'required', 'string', 'max:45'],
            'detalle' => ['sometimes', 'required', 'string'],
            'estatus' => ['sometimes', 'integer', 'in:0,1'],
        ];
    }
}