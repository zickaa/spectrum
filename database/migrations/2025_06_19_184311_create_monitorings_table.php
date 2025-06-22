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
        // Schema::create('monitorings', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });

        // database/migrations/xxxx_create_monitorings_table.php
        Schema::create('monitorings', function (Blueprint $table) {
            $table->id();
            $table->float('nutrisi_ppm')->nullable();
            $table->string('pompa_nutrisi')->nullable();
            $table->string('pompa_aliran')->nullable();
            $table->string('pompa_air')->nullable();
            $table->string('status_nutrisi')->nullable();
            $table->string('status')->nullable();
            $table->float('jarak_air')->nullable();
            $table->string('status_air')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitorings');
    }
};
