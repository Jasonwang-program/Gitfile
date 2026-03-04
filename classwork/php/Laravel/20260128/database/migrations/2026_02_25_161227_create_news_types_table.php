<?php
// database/migrations/2026_02_25_161227_create_news_types_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_types', function (Blueprint $table) {
            $table->id();
            $table->string('typeName', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_types');
    }
};
