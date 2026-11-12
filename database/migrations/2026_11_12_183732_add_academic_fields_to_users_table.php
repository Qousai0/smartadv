<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->foreignId('role_id')
            ->nullable()
            ->constrained('roles');

        $table->foreignId('specialization_id')
            ->nullable()
            ->constrained('specializations');

        $table->unsignedTinyInteger('academic_year')
            ->nullable();
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['role_id']);
        $table->dropForeign(['specialization_id']);

        $table->dropColumn([
            'role_id',
            'specialization_id',
            'academic_year'
        ]);
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */

};
