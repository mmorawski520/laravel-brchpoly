<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BoardStoreRequest extends FormRequest
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
          "BoardName" => "required|min:3|max:32",
          "StartingBalance" => "required|integer|min:2|max:4294967295|gt:0",
          "salary" => "required|integer|min:1|max:4294967295|gt:0", 
          "AmountOfPlayers" => "required|integer|min:2|max:4|gt:0"
        ];
    }
}
