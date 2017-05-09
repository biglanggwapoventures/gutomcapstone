<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 30)->unique();;
            $table->string('firstname', 100);
            $table->string('lastname', 100);
            $table->string('email')->unique();
            $table->string('contact_number', 20);
            $table->string('password');
            $table->string('display_photo')->nullable();
            $table->enum('role', ['ADMIN', 'USER', 'OWNER'])->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
