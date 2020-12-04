<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    public $timestamps = false;
    protected $table = 'lk_payment_types';
    protected $primaryKey = 'pay_id'; 

    public function invoices()
    {
    	return $this->belongsTo(invoices::class);
    }

    protected $fillable = [
        'type'
    ];
}
