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
    protected $balance;
    protected $brch;
    protected $actionType;
    public function __construct($id,$action,$value,$oldActionType)
    {
        $this->id=$id;
        $this->action=$action;
        $this->value=$value;
        $this->brch=explode(",",$id);
        $this->oldActionType=$oldActionType;
        $this->balance=Player::select("players_balance")->where("id","=",$this->brch)->first();
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
        if($this->action!="receive" && $this->action!="receive_from_everyone" && $this->action!="receive" && $this->action!="receive_from_everyone"){
               if(($this->action=="send_to_bank" || $this->action=="send_to_another_player")||($this->oldActionType=="send_to_bank" || $this->oldActionType=="send_to_another_player") ){
        
        if($this->balance->players_balance<$this->value){
            return false;
        }

    }
    if(($this->action=="send_to_everyone" && $this->balance->players_balance<$this->value*3)||($this->oldActionType=="send_to_everyone" && $this->balance->players_balance<$this->value*3)){
            return false;
        }}

     return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __("notEnoughMessage").$this->balance->players_balance;
    }
}
