<?php

use App\Models\Variant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestVariantTable extends Migration
{
    public function up(): void
    {
        Schema::create('test_variant', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Test::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Variant::class)
                ->unique()
                ->constrained()
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_variant');
    }
}
