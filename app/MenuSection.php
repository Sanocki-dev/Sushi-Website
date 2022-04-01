<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// MenuSection table setup and relationships
class MenuSection extends Model
{
    // Creates the table and the defaults
    public $timestamps = false;
    protected $table = 'lk_menu_sections';

    // Used to make a one to many relationship with MenuSection table to MenuItems table
    public function menuSection()
    {
    	return $this->belongsTo(MenuItems::class);
    }
}
