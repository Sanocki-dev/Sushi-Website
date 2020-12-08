<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotions extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_promotions';
    protected $primaryKey = 'promotion_id'; 
    protected $fillable = ['user_id', 'code', 'start_date', 'end_date', 'discount', 'menu_id'];

    public function discount($total)
    {
        return ($this->discount / 100) * $total;
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
