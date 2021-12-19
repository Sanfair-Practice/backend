<?php

use App\Models\Section;
use App\Models\Test;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionTestTable extends Migration
{
    public function up(): void
    {
        Schema::create('section_test', function (Blueprint $table) {
            $table->foreignIdFor(Section::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Test::class)->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('section_test');
    }
}
