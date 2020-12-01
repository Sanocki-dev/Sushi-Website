<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuItems extends Model
{
    public function orderedItems()
    {
    	return $this->belongsTo(orderedItems::class);
    }

}
