<?php

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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')
                ->constrained()
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
            $table->morphs('enrollable');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('status');
            $table->string('notes')->nullable();
            $table->unique([
                'student_id',
                'enrollable_id',
                'enrollable_type',
                'deleted_at',
            ], 'unique_student_enrollment' );
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
