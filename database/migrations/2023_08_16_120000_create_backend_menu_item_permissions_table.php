<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackendMenuItemPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backend_menu_item_permissions', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->unsignedBigInteger('menu_item_id');
            $table->string('permission');
            $table->timestamps();
        });

        Schema::table('backend_menu_item_permissions', function($table) {
            $table->foreign('menu_item_id')->references('id')->on('backend_menu_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backend_menu_item_permissions');
    }
}
