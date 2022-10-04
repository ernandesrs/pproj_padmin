<?php

use App\Models\Page;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();

            $table->string("title", 100)->nullable(false);
            $table->string("description", 160)->nullable(false);
            $table->string("cover")->nullable();
            $table->string("lang", 5)->nullable(false)->default(config("app.locale"))->comment("Idioma. Ex.: pt, pt_BR, en, en_US");
            $table->integer("content_type")->nullable(false)->default(1);
            $table->text("content")->nullable(true);
            $table->boolean("follow")->nullable(false)->default(true);
            $table->integer("protection")->nullable(false)->default(Page::PROTECTION_AUTHOR);
            $table->fullText(["title", "description"]);

            $table->integer("status")->nullable(false)->default(1);
            $table->timestamp("published_at")->nullable(true);
            $table->timestamp("scheduled_to")->nullable(true);

            // FOREIGN KEYS
            $table->foreignId("user_id")->unsigned()->nullable(true);
            $table->foreignId("slug_id")->unsigned()->nullable(false);

            $table->foreign("user_id")->references("id")->on("users")->nullOnDelete();
            $table->foreign("slug_id")->references("id")->on("slugs")->restrictOnDelete();

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
        Schema::dropIfExists('pages');
    }
}
