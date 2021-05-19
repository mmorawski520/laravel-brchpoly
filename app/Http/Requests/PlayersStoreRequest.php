<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlayersStoreRequest extends FormRequest
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
         $AmountOfPlayers=$this->AmountOfPlayers;
        if ($AmountOfPlayers == 2)
        {
            return [
            "PlayerName1" => "required|min:3|max:20",
            "PlayerName2" => "required|min:3|max:20"
        ];
        }
        if ($AmountOfPlayers == 3)
        {
            return [
            "PlayerName1" => "required|min:3|max:20", 
            "PlayerName2" => "required|min:3|max:20",
            "PlayerName3" => "required|min:3|max:20"
        ];
        }
        if ($AmountOfPlayers == 4)
        {
            return [
            "PlayerName1" => "required|min:3|max:20",
            "PlayerName2" => "required|min:3|max:20",
            "PlayerName3" => "required|min:3|max:20", 
            "PlayerName4" => "required|min:3|max:20"
        ];
        }
       
    }
}
