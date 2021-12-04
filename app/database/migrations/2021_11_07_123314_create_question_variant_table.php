<?php

use App\Models\Question;
use App\Models\Variant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionVariantTable extends Migration
{
    public function up(): void
    {
        Schema::create('question_variant', function (Blueprint $table) {
            $table->foreignIdFor(Variant::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Question::class)->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_variant');
    }
}
