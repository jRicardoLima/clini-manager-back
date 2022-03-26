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
        Schema::create('specialtie_health_procedure', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('specialtie_id')->constrained('specialtie');
            $table->foreignId('health_procedure_id')->constrained('health_procedure');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specialtie_health_procedure');
    }
};
