<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVehicleEnginesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicle_engines', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->unsignedBigInteger('name_id');
            $table->string('name');
            $table->string('volume');
            $table->string('power');
            $table->string('fuel');
            $table->string('cm3');
            $table->string('engine_code');
            $table->year('year_from')->nullable();
            $table->year('year_to')->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedInteger('order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_engines');
    }
};
