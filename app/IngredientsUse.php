<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngredientsUse extends Model
{
    protected $table = 'lk_ingredient_use';
    public $timestamps = false;
    protected $fillable = [
       'item_id', 'menu_id'
    ];

    public function menuIngredient()
    {
    	return $this->belongsTo('App\MenuItems', 'menu_id');
    }

    public function ingredient()
    {
    	return $this->belongsTo('App\Ingredients', 'item_id');
    }
}
