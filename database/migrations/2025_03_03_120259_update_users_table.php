<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable()->constrained();
            $table->string('employee_id')->nullable()->unique();
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->string('position')->nullable();
            $table->string('department')->nullable();
            $table->date('hire_date')->nullable();
            $table->decimal('salary', 10, 2)->nullable();
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('role_id');
            $table->dropColumn([
                'employee_id', 'phone_number', 'address', 'position',
                'department', 'hire_date', 'salary', 'is_active'
            ]);
        });
    }
};