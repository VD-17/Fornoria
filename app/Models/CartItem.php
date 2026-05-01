<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cartitems';
    protected $primaryKey = 'cartItem_id';

    protected $fillable = [
        'cart_id',
        'menuItem_id',
        'quantity',
        'total_price'
    ];

    public function cart() {
        return $this->belongsTo(Cart::class, 'cart_id', 'cart_id');
    }

    public function menuItem() {
        return $this->belongsTo(MenuItem::class, 'menuItem_id', 'id');
    }
}
