<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('token_orders', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->integer('tokens_purchased')->nullable(); // Number of tokens purchased
            $table->decimal('usd_paid', 10, 2)->nullable(); // Amount paid in USD
            $table->string('peachpayment_order_id')->nullable(); // Peach Payment Order ID
            $table->string('status')->default('pending'); // Order status
            $table->timestamps(); // Created at & Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('token_orders');
    }
};
