
<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('first_name', 20)->nullable(false);
            $table->string('last_name', 50)->nullable(false);
            $table->string('username', 20)->unique()->nullable(false);
            $table->string('email')->unique();
            $table->string('confirmation_token', 25)->nullable();
            $table->string('photo')->nullable();
            $table->integer('level')->default(0);
            $table->integer('gender')->default(User::GENDER_NONE);
            $table->fullText(['first_name', 'last_name', 'username', 'email']);

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
