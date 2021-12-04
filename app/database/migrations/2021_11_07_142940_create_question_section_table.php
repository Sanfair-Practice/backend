<?php

use App\Models\Question;
use App\Models\Section;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionSectionTable extends Migration
{
    public function up(): void
    {
        Schema::create('question_section', function (Blueprint $table) {
            $table->foreignIdFor(Section::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Question::class)
                ->unique()
                ->constrained()
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_section');
    }
}
