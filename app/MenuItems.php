<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuItems extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_menu_items';
    protected $primaryKey = 'menu_id'; // or null
    protected $fillable = ['section_id', 'name', 'price'];
    
    public function orderedItems()
    {
    	return $this->hasMany('App\OrderedItems', 'menu_id');
    }

    public function menuIngredients()
    {
        return $this->hasMany('App\IngredientsUse', 'menu_id');
    }
}
