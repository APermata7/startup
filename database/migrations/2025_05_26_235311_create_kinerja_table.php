<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('kinerja', function (Blueprint $table) {
            $table->id();
            
            // Karyawan yang memberikan review (reviewer)
            $table->unsignedBigInteger('penilai_id');
            
            // Karyawan yang direview (reviewee)
            $table->unsignedBigInteger('dinilai_id');
            
            // Rating dengan enum nullable
            $table->enum('rating', ['baik', 'sedang', 'buruk'])->nullable();
            
            // Review text nullable
            $table->text('review')->nullable();
            
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('penilai_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('dinilai_id')->references('id')->on('users')->onDelete('cascade');
            
            // Memastikan satu karyawan hanya bisa memberikan 1 review ke karyawan lain
            $table->unique(['penilai_id', 'dinilai_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('kinerja');
    }
};