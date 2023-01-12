<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable(false)->unique();
            $table->string('title', 50)->nullable(false);
            $table->string('description', 75)->nullable();
            $table->json('socials')->default(json_encode([]));

            // FOREIGN KEYS
            $table->foreignId("favicon")->unsigned()->nullable();
            $table->foreignId("logo")->unsigned()->nullable();
            $table->foreignId("menu_header")->unsigned()->nullable();
            $table->foreignId("menu_footer")->unsigned()->nullable();

            $table->foreign("favicon")->references("id")->on("images")->nullOnDelete();
            $table->foreign("logo")->references("id")->on("images")->nullOnDelete();
            $table->foreign("menu_header")->references("id")->on("menus")->nullOnDelete();
            $table->foreign("menu_footer")->references("id")->on("menus")->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
