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
        Schema::create('giaovien', function (Blueprint $table) {
            $table->id('idgiaovien');
            $table->string('tengiaovien');
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
        Schema::dropIfExists('giaovien');
    }
};
