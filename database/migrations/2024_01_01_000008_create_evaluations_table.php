<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id')->constrained()->cascadeOnDelete();
            $table->foreignId('supervisor_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('technical_skills');
            $table->unsignedTinyInteger('communication');
            $table->unsignedTinyInteger('teamwork');
            $table->unsignedTinyInteger('punctuality');
            $table->unsignedTinyInteger('initiative');
            $table->decimal('overall_rating', 3, 2);
            $table->text('comments')->nullable();
            $table->date('evaluation_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
