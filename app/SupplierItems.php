<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Suppliers;

// SupplierItems table setup and relationships
class SupplierItems extends Model
{
    // Creates the table and the defaults
    public $timestamps = false;
    protected $table = 'tbl_supplier_items';

    // Fillable fields 
    protected $fillable = [
        'supplier_id', 'ingredient_id', 'price'
    ];

    // Used to make a one to many relationship with SupplierItems table to Suppliers table
    public function supplier()
    {
    	return $this->belongsTo('App\Suppliers', 'supplier_id');
    }

    // Used to make a one to many relationship with SupplierItems table to Ingredients table
    public function ingredient()
    {
    	return $this->belongsTo('App\Ingredients', 'ingredient_id');
    }
}
