<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// Promotions table setup and relationships
class Promotions extends Model
{
    // Creates the table and the defaults
    public $timestamps = false;
    protected $table = 'tbl_promotions';
    protected $primaryKey = 'promotion_id'; 

    // Fillable fields 
    protected $fillable = [
        'user_id', 'code', 'start_date', 'end_date', 'type', 'discount', 'menu_id'
    ];

    // Function to calculate the total discount of an item
    public function discount($total)
    {
        return ($this->discount / 100) * $total;
    }

    // Used to make a one to many relationship with Promotions table to MenuItems table
    public function menu()
    {
        return $this->belongsTo('App\MenuItems', 'menu_id');
    }
 
    // Used to make a one to many relationship with Promotions table to User table    
    public function user()
    {
        return $this->hasMany('App\User', 'user_id');
    }
}
