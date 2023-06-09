<?php

use App\Models\Rank;
use App\Models\Role;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('experience')->default(0);
            $table->string('picture')->nullable();
            $table->string('banner')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('refresh_token')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->timestamp('blocked_at')->nullable();
            $table->string('description')->nullable();

            // Foreign keys
            $table->foreignIdFor(Rank::class)->default(1);
            $table->foreignIdFor(Role::class)->default(2);
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
};
