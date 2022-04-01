<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// OrderedItems table setup and relationships
class OrderedItems extends Model
{
    // Creates the table and the defaults
    protected $table = 'tbl_ordered_items';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    // Used to make a one to many relationship with OrderedItems table to Invoices table
    public function invoice()
    {
    	return $this->belongsTo('App\Invoices', 'order_id');
    }

    // Used to make a one to many relationship with OrderedItems table to MenuItems table
    public function menuItem()
    {
    	return $this->belongsTo('App\MenuItems', 'menu_id');
    }
}
