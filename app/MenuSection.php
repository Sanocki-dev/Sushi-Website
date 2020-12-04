<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuSection extends Model
{
    public $timestamps = false;
    protected $table = 'lk_menu_sections';
    public function menuSection()
    {
    	return $this->belongsTo(MenuItems::class);
    }
}
