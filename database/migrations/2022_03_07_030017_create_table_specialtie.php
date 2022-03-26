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
        Schema::create('specialtie', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uui')->unique();
            $table->string('name');
            $table->string('cbo')->nullable(true)->default(null);
            $table->foreignId('subsidiary_id')->constrained('subsidiary');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specialtie');
    }
};
