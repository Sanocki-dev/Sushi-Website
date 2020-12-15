<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotions extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_promotions';
    protected $primaryKey = 'promotion_id'; 
    protected $fillable = ['user_id', 'code', 'start_date', 'end_date', 'type', 'discount', 'menu_id'];

    public function discount($type, $total)
    {
        if ($type == 'fixed')
        return ($this->discount / 100) * $total;
        else
        return $total-$this->discount;
    }

    public function menu()
    {
        return $this->belongsTo('App\MenuItems', 'menu_id');
    }
    
    public function user()
    {
        return $this->hasMany('App\User', 'user_id');
    }
}
