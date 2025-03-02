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
        Schema::table('diseases', function (Blueprint $table) {
            $table->string('name_kk')->nullable();
            $table->string('name_ru')->nullable();
            $table->string('name_en')->nullable();
            $table->text('description_kk')->nullable();
            $table->text('description_ru')->nullable();
            $table->text('description_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diseases', function (Blueprint $table) {
            $table->dropColumn([
                'name_kk', 'name_ru', 'name_en',
                'description_kk', 'description_ru', 'description_en'
            ]);
        });
    }
};
