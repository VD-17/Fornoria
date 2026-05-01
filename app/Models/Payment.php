<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'payment_id';

    protected $fillable = [
        'payment_id',
        'order_id',
        'user_id',
        'paymentMethod',
        'amount',
        'transaction_id',
        'dateOfPayment',
        'paymentStatus',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
