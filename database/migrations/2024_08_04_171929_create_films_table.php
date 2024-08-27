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
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(0);
            $table->string('poster')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('duration')->nullable();
            $table->string('country')->nullable();
            $table->json('halls_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
