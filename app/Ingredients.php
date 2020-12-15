<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredients extends Model
{
    protected $table = 'tbl_ingredients';
    protected $primaryKey = 'ingredient_id';
    public $timestamps = false;
    protected $fillable = [
       'name'
    ];

    public function ingredientUse()
    {
    	return $this->hasMany('App\IngredientsUse', 'item_id');
    }

    public function supplier()
    {
    	return $this->hasMany('App\SupplierItems', 'ingredient_id');
    }
}
