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
        Schema::create('product_parameters', function (Blueprint $table) {
            $table->id();
            $table->string('title', 250);
            $table->string('value', 250);
            $table->integer('type')
                ->default(1);
            $table->boolean('is_primary')
                ->nullable();
            $table->integer('param_order');

            $table->unsignedBigInteger('product_group_id')->nullable();
            $table->unsignedBigInteger('product_id');

            $table->foreign('product_id')
                ->references('id')
                ->on('language_pages')
                ->onDelete('cascade');
            $table->foreign('product_group_id')
                ->references('id')
                ->on('product_parameter_groups')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_parameters');
    }
};
