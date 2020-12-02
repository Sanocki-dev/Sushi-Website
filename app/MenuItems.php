<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuItems extends Model
{
    protected $primaryKey = 'menu_ID'; // or null
    protected $fillable = ['section_ID', 'name', 'price'];
    public function orderedItems()
    {
    	return $this->belongsTo(orderedItems::class);
    }

}
