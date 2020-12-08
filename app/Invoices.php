<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    protected $table = 'tbl_invoice';
    protected $primaryKey = 'invoice_id';
    public $timestamps = false;
    protected $fillable = [
        'pay_id', 'user_id', 'date', 'time', 'amount', 'status'
    ];
    
    public function user()
    {
    	return $this->belongsTo('App\User','user_id');
    } 

    public function orderedItems()
    {
    	return $this->hasMany(OrderedItems::class, 'invoice_id');
    }

    public function menuItems()
    {
    	return $this->hasMany(MenuItems::class);
    }
}
