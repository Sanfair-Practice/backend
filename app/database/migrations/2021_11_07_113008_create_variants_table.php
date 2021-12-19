<?php

use App\Enums\Variant;
use App\Models\Test;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantsTable extends Migration
{
    public function up(): void
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('seed');
            $table->integer('time');
            $table->timestamp('end', 0)->nullable();
            $table->integer('errors');
            $table->json('input')->default('[]');
            $table->foreignIdFor(Test::class)->constrained()->onDelete('cascade');
            $table->enum('status', [
                Variant\Status::CREATED,
                Variant\Status::STARTED,
                Variant\Status::FAILED,
                Variant\Status::PASSED,
                Variant\Status::EXPIRED,
            ])->default(Variant\Status::CREATED);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variants');
    }
}
