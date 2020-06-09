<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function deposits(){
        return $this->hasMany('App\Deposit', 'user_id', 'id');
    }
    
    public function withdrawals(){
        return $this->hasMany('App\Withdrawal', 'user_id', 'id');
    }
    
    public function totalDeposit(){
        return $this->deposits()->sum('balance');
    }
    
    public function totalWithdrawal(){
        return $this->withdrawals()->sum('balance');
    }
    
    public function getTotalAmount(){
        return ($this->totalDeposit() - $this->totalWithdrawal());
    }
}
