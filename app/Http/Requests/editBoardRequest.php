<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Board;
class editBoardRequest extends FormRequest
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
            "boardName" => "min:2|max:32|nullable",
          "startingBalance" => "integer|min:1|max:4294967295|gt:0|nullable",
          "salary" => "integer|min:1|max:4294967295|gt:0|nullable", 
           
        ];
    }
}
