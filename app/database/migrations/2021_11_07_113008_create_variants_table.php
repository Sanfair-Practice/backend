<?php

use App\Models\User;
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
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->integer('time');
            $table->timestamp('end', 0);
            $table->integer('errors');
            $table->json('input')->default('[]');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variants');
    }
}
