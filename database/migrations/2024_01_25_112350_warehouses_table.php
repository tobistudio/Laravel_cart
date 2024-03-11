<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('translation_key', 100);
            $table->string('address', 250);
            $table->integer('type')->comment('
                1 - shop,
                2 - self pickup,
                3 - deliver to,
                4 - storage
            ');
            $table->float('max_weight_kg')->nullable();
            $table->float('max_height_cm')->nullable();
            $table->float('max_width_cm')->nullable();
            $table->float('max_volume_cm')->nullable();

            $table->float('deliver_time_from_h')->nullable();
            $table->float('deliver_time_to_h')->nullable();
            $table->float('deliver_price')->nullable();
            $table->float('deliver_price_drops_from')->nullable();

            $table->unsignedBigInteger('warehouse_group_id');

            $table->foreign('translation_key')
                ->references('key')
                ->on('translations')
                ->onDelete('cascade');
            $table->foreign('warehouse_group_id')
                ->references('id')
                ->on('warehouse_groups')
                ->onDelete('cascade');

            $table->timestamps();
        });

        DB::table('backend_menu_items')->insert([
            [
                'type' => 'sidebar',
                'parent_id' => 10,
                'icon' => 'dot',
                'name' => 'shop_warehouses',
                'link' => '/system/shop/warehouses',
                'order' => 10,
                'disabled' => 0,
                'allow_permission' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouses');

        DB::table('backend_menu_items')
            ->where(['name' => 'shop_warehouses'])
            ->delete();
    }
};
