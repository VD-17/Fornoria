<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'orderItem_id';

    protected $fillable = [
        'order_id',
        'menuItem_id',
        'quantity',
        'unit_price',
        'total_price',
    ];

    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function menuItem() {
        return $this->belongsTo(MenuItem::class, 'menuItem_id', 'id');
    }
}
