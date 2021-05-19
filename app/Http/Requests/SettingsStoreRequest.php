<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use  Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Rules\ChangingPassword;
class SettingsStoreRequest extends FormRequest
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
        $currentUser = auth()->user();
        $oldPassword=$this->input("fPassword");

        return [
            
             "fPassword" => "required|string|min:8",
            "nPassword" => ['required','string','min:8','different:fPassword',new ChangingPassword($oldPassword ,$currentUser->password)],
            "nPasswordr" =>['required','string','min:8','same:nPassword'],
        ];
    }
    
    public function messages(){
        return [
           
        ];
    }
}
