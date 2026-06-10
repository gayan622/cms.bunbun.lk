<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Use 'create' instead of 'table' to initialize the table
        Schema::create('heroes', function (Blueprint $table) {
            $table->id(); // Don't forget the ID!
            $table->string('badge')->nullable();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('primary_button_text')->nullable();
            $table->string('secondary_button_text')->nullable();
            $table->string('layout')->nullable();
            $table->boolean('is_active')->default(false);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Simple drop is sufficient for a 'create' migration
        Schema::dropIfExists('heroes');
    }
};
