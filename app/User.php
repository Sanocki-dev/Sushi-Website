<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;
    protected $table = 'tbl_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'name', 'promotions', 'phone'
    ];

    public function setPasswordAttribute($pass){

        $this->attributes['password'] = Hash::make($pass);

    }   

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPromotionsAttribute($value)
    {
        $this->attributes['promotions'] = ($value=='on');
    }

    public function invoices()
    {
        return $this->hasMany(tbl_invoice::class);
    }

}
