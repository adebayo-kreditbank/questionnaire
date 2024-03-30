<?php

use App\Models\Product;
use App\Models\Question;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('behaviours', function (Blueprint $table) {
            $table->id();
            $table->string('label')->nullable();
            $table->foreignIdFor(Question::class)->nullable();
            $table->foreignIdFor(Product::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('behaviours');
    }
};
