<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();

            $table->integer('type')->default(0);
            $table->string('name', 25)->unique();
            $table->string('title', 50)->unique();
            $table->string('subtitle', 75)->nullable();
            $table->text('content')->nullable();
            $table->boolean('visible')->default(false);
            $table->json('buttons')->default(json_encode([]));

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
        Schema::dropIfExists('sections');
    }
}
