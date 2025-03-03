<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('career_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('type'); // promotion, salary_change, training
            $table->date('date');
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('previous_salary', 10, 2)->nullable();
            $table->decimal('new_salary', 10, 2)->nullable();
            $table->string('previous_position')->nullable();
            $table->string('new_position')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('career_events');
    }
};