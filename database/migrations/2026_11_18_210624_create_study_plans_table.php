<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('study_plans', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->foreignId('specialization_id')
                  ->constrained('specializations')
                  ->restrictOnDelete();

            $table->string('version')->nullable();

            $table->unsignedSmallInteger('total_credit_hours');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('study_plans');
    }
};
