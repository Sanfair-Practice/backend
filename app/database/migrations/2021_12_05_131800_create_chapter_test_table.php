<?php

use App\Models\Chapter;
use App\Models\Test;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapterTestTable extends Migration
{
    public function up(): void
    {
        Schema::create('chapter_test', function (Blueprint $table) {
            $table->foreignIdFor(Chapter::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Test::class)->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chapter_test');
    }
}
