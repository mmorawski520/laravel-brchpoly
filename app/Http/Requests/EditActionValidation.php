<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Rule;
use App\Rules\IfHaveEnough;
 
class EditActionValidation extends FormRequest
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
            
            "ReceiveValue"=>"Required|Integer|min:1|max:4294967295|gt:0",
            "playerSelect"=>["Required_if:actionSelect,send_to_another_player",new IfHaveEnough(explode(",",$this->id)[1],$this->input("actionSelect"),$this->input("ReceiveValue"),explode(",",$this->id)[2])],
            
        ];
    }
}
