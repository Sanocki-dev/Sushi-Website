<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    protected $table = 'tbl_invoice';
    protected $primaryKey = 'invoice_id';
    public $timestamps = false;
    protected $fillable = [
       'user_id', 'amount'
    ];
    
    public function user()
    {
    	return $this->belongsTo('App\User','user_id');
    } 

    public function invoiceOrder()
    {
    	return $this->belongsTo('App\Order', 'order_id');
    }

    public function invoicesOrder()
    {
    	return $this->hasOne('App\Order', 'order_id');
    }

    public function menuItems()
    {
    	return $this->hasMany(MenuItems::class);
    }
}
