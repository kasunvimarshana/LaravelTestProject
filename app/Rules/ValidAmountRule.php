<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\User;

class ValidAmountRule implements Rule
{
    public $user;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        //
        $this->user = $user;
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
        //
        if (!$this->user instanceof User) {
            return false;
        }
        
        $totalAmount = $this->user->getTotalAmount();
        if( $value <= $totalAmount ){
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'invalid amount';
    }
}
