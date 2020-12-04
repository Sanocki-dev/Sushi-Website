<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditInfo extends Model
{
    protected $table = 'tbl_credit_info';
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'type', 'name', 'number', 'exp_date'
    ];

    protected $primaryKey = 'credit_id';

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function paymentType()
    {
        return $this->hasMany('App\PaymentType', 'pay_id');
    }
}
