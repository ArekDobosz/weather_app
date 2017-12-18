<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
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
            'email' => 'required|unique:users|email',
            'max_temp' => 'min:-99|max:99|integer|nullable',
            'min_temp' => 'min:-99|max:99|integer|nullable',
            'radiation' => 'min:0|max:11|integer|nullable',
            'max_humidity' => 'min:0|max:100|integer|nullable',
            'min_humidity' => 'min:0|max:100|integer|nullable',
            'wind' => 'min:0|max:200|integer|nullable',
        ];
    }

    public function messages() 
    {
        return [
            'email.unique' => 'Adres e-mail jest zajęty.',
            'email.required' => 'Adres e-mail jest polem wymaganym.',
            'email.email' => 'Wpisany adres e-mail jest nieprawidłowy.',
            'max_temp.min' => 'Min wartość temperatury to :min',
            'max_temp.max' => 'Max wartość temperatury to :max',
            'min_temp.min' => 'Min wartość temperatury to :min',
            'min_temp.max' => 'Max wartość temperatury to :max',
            'radiation.min' => 'Min wartość indeksu UV to :min',
            'radiation.max' => 'Max wartość indeksu UV to :max',
            'max_humidity.min' => 'Min wartość wilgotności to :min',
            'max_humidity.max' => 'Max wartość wilgotności to :max',
            'min_humidity.min' => 'Min wartość wilgotności to :min',
            'min_humidity.max' => 'Max wartość wilgotności to :max',
            'wind.min' => 'Min wartość siły wiatru to :min',
            'wind.max' => 'Max wartość siły wiatru to :max',
        ];
    }
}
