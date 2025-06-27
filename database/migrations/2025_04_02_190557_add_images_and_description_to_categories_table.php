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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('banner_image')->nullable()->after('slug');
            $table->string('selection_image')->nullable()->after('banner_image');
            $table->text('description')->nullable()->after('selection_image');
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['banner_image', 'selection_image', 'description']);
        });
    }
};
