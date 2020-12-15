<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Suppliers;

class SupplierItems extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_supplier_items';

    protected $fillable = [
        'supplier_id', 'ingredient_id', 'price'
    ];

    public function supplier()
    {
    	return $this->belongsTo('App\Suppliers', 'supplier_id');
    }

    public function ingredient()
    {
    	return $this->belongsTo('App\Ingredients', 'ingredient_id');
    }
}
