<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CultoRequest extends FormRequest
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
            'nom_culto' => 'required|min:3|max:50',
            'dia_culto' => 'required|in:S,T,Q,U,S,A,D',
            'periodo' => 'required|in:M,T,N,I'
        ];
    }
}
