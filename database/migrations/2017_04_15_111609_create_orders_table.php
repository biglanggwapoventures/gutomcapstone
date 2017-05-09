<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('restaurant_id');
            $table->enum('order_type', ['PICK_UP', 'DINE_IN']);
            $table->enum('payment_type', ['CASH', 'CREDIT_CARD']);
            $table->string('name', 100);
            $table->string('contact_number', 15);
            $table->date('order_date');
            $table->time('order_time');
            $table->time('cook_time')->nullable();
            $table->unsignedInteger('guest_count')->nullable();
            $table->enum('order_status', ['PENDING', 'APPROVED', 'CANCELLED'])->default('PENDING');
            $table->string('remarks', 255)->nullable();
            $table->boolean('seen_by_user')->default(false);
            $table->boolean('seen_by_restaurant')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
