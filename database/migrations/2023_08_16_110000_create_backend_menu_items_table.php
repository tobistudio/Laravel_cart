<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackendMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backend_menu_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->string('type');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('icon')->nullable();
            $table->string('name');
            $table->string('link')->nullable();
            $table->tinyInteger('order');
            $table->boolean('disabled')->default(false);
            $table->boolean('allow_permission')->default(false);
            $table->timestamps();
        });

        Schema::table('backend_menu_items', function($table) {
            $table->foreign('parent_id')->references('id')->on('backend_menu_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backend_menu_items');
    }
}
