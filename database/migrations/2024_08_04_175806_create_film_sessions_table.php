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
        Schema::create('film_sessions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('film_id')->unsigned();
            $table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');
            $table->string('film_name')->nullable();
            $table->integer('hall_id')->nullable();
            $table->integer('start_h')->nullable();
            $table->integer('start_m')->nullable();
            $table->integer('duration')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('film_sessions');
    }
};
