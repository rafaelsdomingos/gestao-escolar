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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            //$table->string('registration_number')->unique();
            $table->string('name');
            $table->string('social_name')->nullable();
            $table->string('nationality');
            $table->string('birthplace');
            $table->date('birthdate');
            $table->string('gender');
            $table->string('race_color');
            $table->string('address')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city')->nullable();
            $table->string('uf')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('ser');
            $table->string('cel_number')->nullable();
            $table->string('email')->nullable();
            $table->string('education_level');
            $table->string('grade')->nullable();
            $table->string('shift')->nullable();
            $table->string('institution')->nullable();
            $table->string('institution_type')->nullable();
            $table->string('cpf')->nullable()->unique();
            $table->string('rg')->nullable()->unique();
            $table->string('rg_authority')->nullable();
            $table->string('rg_state')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_rg')->nullable();
            $table->string('mother_rg_authority')->nullable();
            $table->string('mother_rg_state')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_rg')->nullable();
            $table->string('father_rg_authority')->nullable();
            $table->string('father_rg_state')->nullable();
            $table->string('photo')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
