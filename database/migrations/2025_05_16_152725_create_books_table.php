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
        Schema::create('books', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->foreignId('author_id')->constrained()->onDelete('cascade');
    $table->foreignId('genre_id')->constrained()->onDelete('cascade');  
    $table->integer('price');
    $table->integer('stock')->default(0);
    $table->date('published_at');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
