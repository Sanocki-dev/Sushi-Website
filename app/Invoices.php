<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// Invoice table setup and relationships
class Invoices extends Model
{
    protected $table = 'tbl_invoice';
    protected $primaryKey = 'invoice_id';
    public $timestamps = false;

    // Fillable fields 
    protected $fillable = [
       'user_id', 'amount'
    ];
    
    // Used to make a relationship with Invoice table to User table
    public function user()
    {
    	return $this->belongsTo('App\User','user_id');
    } 

    // Used to make a relationship with Invoice table to Order table
    public function invoiceOrder()
    {
    	return $this->belongsTo('App\Order', 'order_id');
    }

    // Used to make a one to one relationship with Invoice table to Order table
    public function invoicesOrder()
    {
    	return $this->hasOne('App\Order', 'order_id');
    }

    // Used to make a many to many relationship with Invoice table to MenuItems table
    public function menuItems()
    {
    	return $this->hasMany(MenuItems::class);
    }
}
