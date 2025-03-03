<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->constrained();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->date('birth_date')->nullable();
            $table->date('hire_date');
            $table->string('position');
            $table->string('contract_type'); // CDI, CDD, Freelance, Stage
            $table->decimal('salary', 10, 2)->nullable();
            $table->string('status')->default('active'); // active, inactive, on_leave
            $table->foreignId('manager_id')->nullable()->constrained('employees');
            $table->text('address')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
};