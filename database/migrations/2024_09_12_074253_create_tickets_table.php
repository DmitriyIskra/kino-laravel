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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->text('qr')->nullable();
            $table->bigInteger('sess_id')->unsigned(); 
            $table->foreign('sess_id')->references('id')->on('film_sessions')->onDelete('cascade');
            $table->text('date')->nullable();
            $table->text('title')->nullable();
            $table->json('places')->nullable();
            $table->integer('hall')->nullable();
            $table->string('start')->nullable();
            $table->decimal('price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
