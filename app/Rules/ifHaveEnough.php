<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Board;
use App\Models\Player;
use App\Models\PlayerActions;
class ifHaveEnough implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $id;
    protected $action;
    protected $value;
    public function __construct($id,$action,$value)
    {
        $this->id=$id;
        $this->action=$action;
        $this->value=$value;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        if($this->action=="send_to_bank" || $this->action=="send_to_another_player"|| $this->action=="send_to_everyone"){
        $balance=Player::select("players_balance")->where("id","=",$this->id);
        if($balance>$this->value){
            return false;
        }

    }
     return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return _("You aren't rich enough :/");
    }
}
