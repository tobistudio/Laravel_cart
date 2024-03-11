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
        Schema::create('product_relations', function (Blueprint $table) {
            $table->id();
            $table->integer('type');

            $table->unsignedBigInteger('related_product_id');
            $table->unsignedBigInteger('product_id');

            $table->foreign('related_product_id')
                ->references('id')
                ->on('pages');
            $table->foreign('product_id')
                ->references('id')
                ->on('pages');

            $table->timestamps();
        });

        Schema::table('product_data', function(Blueprint $table) {
            if (Schema::hasColumn('product_data', 'is_popular') === false) {
                $table->boolean('is_popular')
                    ->nullable()
                    ->after('special_price');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_relations');

        Schema::table('product_data', function(Blueprint $table) {
            $table->dropColumn('is_popular');
        });
    }
};
