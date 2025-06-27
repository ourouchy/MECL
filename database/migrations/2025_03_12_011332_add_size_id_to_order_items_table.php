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
        Schema::table('order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('size_id')->nullable()->after('product_id');
            // Optional: Add a foreign key constraint
            $table->foreign('size_id')->references('id')->on('sizes')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // First drop the foreign key if you added it
            $table->dropForeign(['size_id']);
            $table->dropColumn('size_id');
        });
    }
};
