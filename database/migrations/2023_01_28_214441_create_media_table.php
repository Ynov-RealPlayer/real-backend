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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('user_id');
            $table->string('description');
            $table->foreignId('category_id');
            $table->string('media_type');
            $table->string('url');
            $table->float('duration');
            $table->timestamps();
            $table->integer('nb_like');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
};
