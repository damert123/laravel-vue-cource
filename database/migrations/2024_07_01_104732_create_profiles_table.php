<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->date('birthed_at')->nullable();
            $table->string('role')->nullable();
            $table->unsignedSmallInteger('status')->default(0);
            $table->string('city')->nullable();
            $table->string('about')->nullable();
            $table->string('avatar_path')->nullable();
            $table->string('login');
//            $table->morphs('profileable');
            $table->foreignId('user_id')->index()->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
