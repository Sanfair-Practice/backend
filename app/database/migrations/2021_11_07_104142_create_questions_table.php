<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('text');
            $table->string('answer');
            $table->json('dummy');
            $table->text('rules');
            $table->text('explanation');
            $table->foreignIdFor(Category::class);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
}
