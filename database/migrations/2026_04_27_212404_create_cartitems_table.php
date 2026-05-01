<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cartitems', function (Blueprint $table) {
            $table->id('cartItem_id');

            $table->unsignedBigInteger('cart_id');
            $table->foreign('cart_id')
                  ->references('cart_id')
                  ->on('carts')
                  ->onDelete('cascade');

            $table->foreignId('menuItem_id')
                  ->constrained('menu_items')
                  ->onDelete('cascade');

            $table->integer('quantity')->default(1);
            $table->decimal('total_price', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cartitems');
    }
};
