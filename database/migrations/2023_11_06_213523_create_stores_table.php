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
        Schema::create('stores', function (Blueprint $table) {
            $table->id(); // id =>BIGINT(24 digit) UNSIGNED,auto increment,primary
            $table->string('name'); //string==>varchar ==>default(255)
            $table->string('slug')->unique(); //help in SEO
            $table->text('description')->nullable(); //64000 chars
            $table->string('logo')->nullable();
            $table->string('cover')->nullable();
            $table->enum('status',['active','inactive'])->default('active'); //to make options
            $table->timestamps(); //2 columns : create_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
};
