<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('performance_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('reviewer_id')->constrained('users');
            $table->date('review_date');
            $table->integer('rating'); // 1-5
            $table->text('achievements')->nullable();
            $table->text('areas_for_improvement')->nullable();
            $table->text('goals')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_reviews');
    }
};
