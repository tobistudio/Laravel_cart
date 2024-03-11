<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLanguagePagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('language_pages', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->unsignedBigInteger('page_id');
            $table->unsignedSmallInteger('language_id');
            $table->string('type')->default('page');
            $table->string('name');
            $table->string('slug');
            $table->longText('description')->nullable();
            $table->boolean('page_header')->default(false);
            $table->string('featured_image')->nullable();
            $table->boolean('featured_image_big')->default(false);
            $table->boolean('breadcrumbs')->default(false);
            $table->boolean('newsletter')->default(false);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_image')->nullable();
            $table->boolean('index')->default(true);
            $table->boolean('fallow')->default(true);
            $table->boolean('popular')->default(false);
            $table->boolean('status')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('language_pages');
    }
};
