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
        Schema::create('cuadrilleros', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('work_role');
            $table->string('work_place');
            $table->string('sdn');
            $table->string('RFC');
            $table->boolean('active')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {        
        Schema::dropIfExists('cuadrilleros');
    }
};
