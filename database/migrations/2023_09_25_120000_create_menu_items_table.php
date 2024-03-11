<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->unsignedSmallInteger('menu_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->string('text');
            $table->string('url')->nullable();
            $table->boolean('open_in_new_tab')->default(false);
            $table->string('type');
            $table->timestamps();

            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
