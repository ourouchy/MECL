<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOriginalPriceToProductSizeTable extends Migration
{
    public function up()
    {
        Schema::table('product_size', function (Blueprint $table) {
            $table->decimal('original_price', 10, 2)->nullable()->after('price');
        });
    }

    public function down()
    {
        Schema::table('product_size', function (Blueprint $table) {
            $table->dropColumn('original_price');
        });
    }
}
