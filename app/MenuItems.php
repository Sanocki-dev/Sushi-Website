<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// MenuItems table setup and relationships
class MenuItems extends Model
{
    // Creates the table and the defaults
    public $timestamps = false;
    protected $table = 'tbl_menu_items';
    protected $primaryKey = 'menu_id'; // or null

    // Fillable fields 
    protected $fillable = ['section_id', 'name', 'price'];
    
    // Used to make a many to many relationship with MenuItems table to orderedItems table
    public function orderedItems()
    {
    	return $this->hasMany('App\OrderedItems', 'menu_id');
    }

    // Used to make a many to many relationship with MenuItems table to menuIngredients table
    public function menuIngredients()
    {
        return $this->hasMany('App\IngredientsUse', 'menu_id');
    }
}
