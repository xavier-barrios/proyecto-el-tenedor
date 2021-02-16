<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class modificarRestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'required',
            'cp' => 'required|max:5',
            'calle' => 'required',
            'ciudad' => 'required',
            'tipoCocina' => 'required',
            'precio_medio' => 'required',
        ];
    }
}
