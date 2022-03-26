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
        Schema::create('health_procedure', function (Blueprint $table) {
           $table->bigIncrements('id');
           $table->uuid('uuid')->unique();
           $table->string('name');
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
        Schema::dropIfExists('health_procedure');
    }
};
