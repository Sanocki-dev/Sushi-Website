<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'tbl_orders';
    protected $primaryKey = 'order_id';
    public $timestamps = false;
    protected $fillable = [
       'invoice_id', 'pickup_date', 'pickup_time', 'status'
    ];
    
    public function orderInvoice()
    {
    	return $this->belongsTo('App\Invoices', 'order_id');
    }

    public function orderedInvoices()
    {
    	return $this->hasMany('App\Invoices', 'order_id');
    }

    public function orderItems()
    {
    	return $this->hasMany('App\OrderedItems', 'order_id');
    }

    public function orderedItem()
    {
    	return $this->hasOne('App\OrderedItems', 'order_id');
    }
}
