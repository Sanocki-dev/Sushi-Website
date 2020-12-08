<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderedItems extends Model
{
    protected $table = 'tbl_ordered_items';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    public function invoice()
    {
    	return $this->belongsTo('App\Invoices', 'invoice_id');
    }

    public function menuItem()
    {
    	return $this->belongsTo('App\MenuItems', 'menu_id');
    }
}
