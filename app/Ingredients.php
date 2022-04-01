<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// Ingredients table setup and relationships
class Ingredients extends Model
{
    // Creates the table and the defaults
    protected $table = 'tbl_ingredients';
    protected $primaryKey = 'ingredient_id';
    public $timestamps = false;

    // Fillable fields 
    protected $fillable = [
       'name'
    ];

    // Used to make a many to many relationship with Ingredients table to IngredientsUsed table
    public function ingredientUse()
    {
    	return $this->hasMany('App\IngredientsUse', 'item_id');
    }

    // Used to make a many to many relationship with Ingredients table to SupplierItems table
    public function supplier()
    {
    	return $this->hasMany('App\SupplierItems', 'ingredient_id');
    }
}
