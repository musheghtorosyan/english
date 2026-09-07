<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->string('word');
            $table->string('translation_hy')->nullable();
            $table->string('translation_ru')->nullable();
            $table->string('level', 4)->index();
            $table->string('part_of_speech', 32)->nullable();
            $table->unsignedInteger('frequency_rank')->index();
            $table->timestamps();

            $table->unique('word');
            $table->index(['level', 'frequency_rank']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('words');
    }
};
