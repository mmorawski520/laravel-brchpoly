<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use  Illuminate\Support\Facades\Hash;
class passwordValidation implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $nPassword;
    protected $cPassword;
    public function __construct($nPassword,$cPassword)
    {
        $this->nPassword=$nPassword;
        $this->cPassword=$cPassword;
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
        if(!Hash::check($this->nPassword,$this->cPassword)){
            return false;
        }
        else{
              $currentUser = auth()->user();
            $currentUser->delete();
            return redirect("/");
           
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Password is incorrect.';
    }
}
