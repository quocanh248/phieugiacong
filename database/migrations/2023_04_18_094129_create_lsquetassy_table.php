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
        Schema::create('lsquetassy', function (Blueprint $table) {
            Schema::create('lsquetassy', function (Blueprint $table) {
                $table->id();
                $table->string('tenmodel');
                $table->string('assy');
                $table->string('stt');
                $table->string('maline');
                $table->string('lot');
                $table->timestamps();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lsquetassy');
    }
};
