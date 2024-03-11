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
        Schema::create('product_category_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_category_id');

            $table->foreign('product_category_id')
                ->references('id')
                ->on('language_pages')
                ->onDelete('cascade');

            $table->string('display_mode', 20)->default('products');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_category_data');
    }
};
