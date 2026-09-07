<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phrases', function (Blueprint $table) {
            $table->id();
            $table->string('phrase');
            $table->string('translation_hy');
            $table->string('translation_ru');
            $table->string('category', 32)->index();
            $table->string('level', 4)->index();
            $table->text('example_en')->nullable();
            $table->timestamps();

            $table->unique('phrase');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phrases');
    }
};
