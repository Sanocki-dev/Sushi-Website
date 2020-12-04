<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_invoice';
    protected $fillable = [
        'pay_ID', 'user_id', 'date', 'time', 'amount'
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
