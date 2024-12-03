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
        Schema::create('fstoken', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('password');
            $table->string('grand_type');
            $table->string('created')->nullable();
            $table->string('access_token')->nullable();
            $table->string('token_type')->nullable();
            $table->string('expires_in')->nullable();
            $table->string('refresh_token')->nullable();
            $table->string('grand_type_refresh_token')->nullable();
            $table->boolean('first_login')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fstoken');
    }
};
