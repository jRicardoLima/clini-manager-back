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
    public function up()
    {
        Schema::table('health_insurance', function (Blueprint $table) {
            $table->foreignId('address_id')->constrained('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('health_insurance', function (Blueprint $table) {
            $table->dropConstrainedForeignId('address_id');
            $table->dropColumn('address_id');
        });
    }
};
