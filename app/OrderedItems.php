<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderedItems extends Model
{
    protected $table = 'tbl_ordered_items';

    public $timestamps = false;
    public function invoices()
    {
    	return $this->belongsTo(Invoice::class);
    }

    public function menuItems()
    {
    	return $this->belongsTo(MenuItems::class);
    }
}
