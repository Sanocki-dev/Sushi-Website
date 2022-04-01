<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// Suppliers table setup and relationships
class Suppliers extends Model
{
    // Creates the table and the defaults
    public $timestamps = false;
    protected $table = 'tbl_suppliers';
    protected $primaryKey = 'supplier_id';

    // Fillable fields 
    protected $fillable = [
        'name', 'phone', 'email', 'website', 'address', 'comments'
    ];

    // Used to make a many to many relationship with Suppliers table to SupplierItems table
    public function supplierItems()
    {
    	return $this->hasMany('App\SupplierItems', 'supplier_id');
    }
}
