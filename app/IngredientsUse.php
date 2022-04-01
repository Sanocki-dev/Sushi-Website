<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// IngredientsUse table setup and relationships
class IngredientsUse extends Model
{
    protected $table = 'lk_ingredient_use';
    public $timestamps = false;

    // Fillable fields 
    protected $fillable = [
       'item_id', 'menu_id'
    ];

    // Used to make a relationship with IngredientsUse table to menuIngredient table
    public function menuIngredient()
    {
    	return $this->belongsTo('App\MenuItems', 'menu_id');
    }

    // Used to make a relationship with IngredientsUse table to Ingredients table
    public function ingredient()
    {
    	return $this->belongsTo('App\Ingredients', 'item_id');
    }
}
