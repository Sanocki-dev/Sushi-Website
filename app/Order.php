<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// Ingredients table setup and relationships
class Order extends Model
{
    // Creates the table and the defaults
    protected $table = 'tbl_orders';
    protected $primaryKey = 'order_id';
    public $timestamps = false;

    // Fillable fields 
    protected $fillable = [
       'invoice_id', 'pickup_date', 'pickup_time', 'status'
    ];

    // Used to make a one to many relationship with Order table to Invoices table  
    public function orderInvoice()
    {
    	return $this->belongsTo('App\Invoices', 'order_id');
    }

    // Used to make a many to many relationship with Order table to Invoices table  
    public function orderedInvoices()
    {
    	return $this->hasMany('App\Invoices', 'order_id');
    }

    // Used to make a many to many relationship with Order table to OrderedItems table  
    public function orderItems()
    {
    	return $this->hasMany('App\OrderedItems', 'order_id');
    }

    // Used to make a one to one relationship with Order table to OrderedItems table  
    public function orderedItem()
    {
    	return $this->hasOne('App\OrderedItems', 'order_id');
    }
}
