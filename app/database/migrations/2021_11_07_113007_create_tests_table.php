<?php

use App\Enums\Test;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    public function up(): void
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(User::class);
            $table->unsignedInteger('quantity');
            $table->integer('errors');
            $table->integer('time');
            $table->enum('status', [
                Test\Status::CREATED,
                Test\Status::STARTED,
                Test\Status::FAILED,
                Test\Status::PASSED,
                Test\Status::EXPIRED,
            ]);
            $table->enum('type', [
                Test\Type::TRAINING,
                Test\Type::TEST,
                Test\Type::EXAM,
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
}
