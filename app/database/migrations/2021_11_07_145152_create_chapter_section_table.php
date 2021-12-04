<?php

use App\Models\Chapter;
use App\Models\Section;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapterSectionTable extends Migration
{
    public function up(): void
    {
        Schema::create('chapter_section', function (Blueprint $table) {
            $table->foreignIdFor(Chapter::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Section::class)
                ->unique()
                ->constrained()
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chapter_section');
    }
}
