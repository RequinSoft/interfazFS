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
        Schema::create('assistance', function (Blueprint $table) {
            $table->id();
            $table->string('id_hik')->nullable();
            $table->string('id_fs')->nullable();
            $table->string('ingreso')->nullable();
            $table->timestamp('datetime');
            $table->date('date');
            $table->time('time');
            $table->string('device');
            $table->string('name');
            $table->string('accessgroup');
            $table->boolean('exist_fs')->default(0);
            $table->boolean('sync')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assistance');
    }
};
