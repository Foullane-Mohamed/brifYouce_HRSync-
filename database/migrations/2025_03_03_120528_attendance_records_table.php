<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->date('date');
            $table->time('clock_in')->nullable();
            $table->time('clock_out')->nullable();
            $table->time('break_start')->nullable();
            $table->time('break_end')->nullable();
            $table->string('status')->default('present'); // present, absent, late, etc.
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};

