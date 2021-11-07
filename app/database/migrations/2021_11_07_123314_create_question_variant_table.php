<?php

use App\Models\Question;
use App\Models\Variant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionVariantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_variant', function (Blueprint $table) {
            $table->foreignIdFor(Variant::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Question::class)->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_variant');
    }
}
