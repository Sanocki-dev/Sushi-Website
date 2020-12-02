<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuSection extends Model
{
    public function menuSection()
    {
    	return $this->belongsTo(MenuItems::class);
    }
}
