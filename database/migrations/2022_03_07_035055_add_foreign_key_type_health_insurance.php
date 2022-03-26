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
            $table->foreignId('type_health_insurance_id')->constrained('type_health_insurance');
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
            $table->dropConstrainedForeignId('type_health_insurance_id');
            $table->dropColumn('type_health_insurance');
        });
    }
};
