<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'user_id',
        'orderDate',
        'totalAmount',
        'status',
        'deliveryAddress',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

    public function payment() {
        return $this->hasOne(Payment::class, 'order_id', 'order_id');
    }
}
