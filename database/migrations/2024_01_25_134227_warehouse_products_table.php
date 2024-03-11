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
        Schema::table('product_data', function (Blueprint $table) {
            if (Schema::hasColumn('product_data', 'deliverable_weight_kg') === false
                && Schema::hasColumn('product_data', 'deliverable_height_cm') === false
                && Schema::hasColumn('product_data', 'deliverable_width_cm') === false
                && Schema::hasColumn('product_data', 'deliverable_volume_cm') === false
            )
            {
                $table->after('special_price', function (Blueprint $table) {
                    $table->float('deliverable_weight_kg')
                        ->nullable()
                        ->comment('deliverable box wight');
                    $table->float('deliverable_height_cm')
                        ->nullable()
                        ->comment('deliverable box height');
                    $table->float('deliverable_width_cm')
                        ->nullable()
                        ->comment('deliverable box width');
                    $table->float('deliverable_volume_cm')
                        ->nullable()
                        ->comment('deliverable box volume');
                });
            }
        });

        Schema::create('warehouse_products', function (Blueprint $table) {
            $table->id();

            $table->integer('product_count');
            $table->float('product_price')
                ->nullable()
                ->comment('deliverable box price');

            $table->unsignedBigInteger('warehouse_id');
            $table->unsignedBigInteger('product_id');

            $table->foreign('product_id')
                ->references('id')
                ->on('pages')
                ->onDelete('cascade');
            $table->foreign('warehouse_id')
                ->references('id')
                ->on('warehouses')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_products');

        Schema::table('product_data', function (Blueprint $table) {
            $table->dropColumn([
                'deliverable_weight_kg',
                'deliverable_height_cm',
                'deliverable_width_cm',
                'deliverable_volume_cm',
            ]);
        });
    }
};
