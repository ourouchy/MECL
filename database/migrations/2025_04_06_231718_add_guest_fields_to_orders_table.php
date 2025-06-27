<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('guest_first_name')->nullable()->after('guest_email');
            $table->string('guest_last_name')->nullable();
            $table->string('guest_phone')->nullable();
            $table->string('guest_address1')->nullable();
            $table->string('guest_address2')->nullable();
            $table->string('guest_city')->nullable();
            $table->string('guest_state')->nullable();
            $table->string('guest_country')->nullable();
            $table->string('guest_zipcode')->nullable();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'guest_first_name',
                'guest_last_name',
                'guest_phone',
                'guest_address1',
                'guest_address2',
                'guest_city',
                'guest_state',
                'guest_country',
                'guest_zipcode',
            ]);
        });
    }
};
