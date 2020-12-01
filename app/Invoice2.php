<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_ID', 'pay_ID'
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
