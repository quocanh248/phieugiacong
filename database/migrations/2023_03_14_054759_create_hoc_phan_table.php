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
        Schema::create('hoc_phan', function (Blueprint $table) {
            $table->id('idhocphan');
            $table->string('tenhocphan');
            $table->unsignedBigInteger('idnhomhocphan');
            $table->foreign('idnhomhocphan') 
            -> references('idnhomhocphan') -> on('nhom_hoc_phan')
            -> onUpdate('cascade')
            -> onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoc_phan');
    }
};
