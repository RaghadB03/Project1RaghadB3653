<<?php

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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('no')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('imgUrl')->nullable();
            $table->boolean('isActive')->default(1);
            $table->boolean('isGraduated')->default(0);
            $table->boolean('dismissed')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};