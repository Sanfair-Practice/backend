<?php

use App\Models\Chapter;
use App\Models\Section;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapterSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter_section', function (Blueprint $table) {
            $table->foreignIdFor(Chapter::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Section::class)
                ->unique()
                ->constrained()
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chapter_section');
    }
}
