<?php

use App\Models\Rank;
use App\Models\Role;
use App\Models\Badge;
use App\Models\Media;
use App\Models\Commentary;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('pseudo')->unique();
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
            $table->foreignIdFor(Rank::class);
            $table->foreignIdFor(Badge::class)->nullable();
            $table->foreignIdFor(Role::class);
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
