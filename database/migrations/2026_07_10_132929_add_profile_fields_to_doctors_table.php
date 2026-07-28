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
        Schema::table('doctors', function (Blueprint $table) {
            $table->text('bio')->nullable();
            $table->string('profile_photo')->nullable();
            $table->text('available_days')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->integer('consultation_fee')->nullable()->default(150);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            //
        });
    }
};
