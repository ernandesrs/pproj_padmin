<?php

use App\Models\Section\Section;
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

            $table->string('type')->default(Section::TYPE_DEFAULT);
            $table->string('name', 25)->unique();
            $table->string('title', 50);
            $table->string('subtitle', 75)->nullable();
            $table->string('bindable_class', 125)->nullable()->default(null);
            $table->text('content')->nullable();
            $table->json('buttons')->default(json_encode([]));
            $table->boolean('visible')->default(false);
            $table->fullText(['name', 'title']);

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
