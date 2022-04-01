<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

// User table setup and relationships
class User extends Authenticatable
{
    use Notifiable;
    
    // Creates the table and the defaults
    public $timestamps = false;
    protected $table = 'tbl_users';
    protected $primaryKey = 'user_id';

    // Fillable fields 
    protected $fillable = [
        'email', 'password', 'name', 'promotions', 'phone'
    ];

    // Sets the user password and hashes it
    public function setPasswordAttribute($pass){
        $this->attributes['password'] = Hash::make($pass);
    }   

    // Protected fields 
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Used to make a many to many relationship with User table to Invoices table   
    public function invoices()
    {
        return $this->hasMany(Invoices::class);
    }

    public function credit()
    {
        return $this->hasOne(CreditInfo::class, 'user_id');
    }
}
