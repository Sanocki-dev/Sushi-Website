<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_invoice extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'pay_ID', 'id', 'date', 'time', 'amount'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    } 

    public function orderedItems()
    {
    	return $this->hasMany(OrderedItems::class);
    }

    public function menuItems()
    {
    	return $this->hasMany(MenuItems::class);
    }
}
