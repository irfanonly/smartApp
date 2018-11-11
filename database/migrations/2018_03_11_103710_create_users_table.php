<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $this->down();
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 20);
            $table->string('password');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->bigInteger('user_groub_id');
            $table->string('email', 100)->nullable();
            $table->string('contact_no', 12);
            $table->string('user_image');
            $table->string('forget_password_token')->nullable();
            $table->tinyInteger('is_delete')->default('0');
            $table->timestamps();
        });
        $data = array(
            array(
                'username' => 'admin',
                'password' => '24d3c6fe567c74749a2534b1ca2bd3d611528e27',
                'first_name' => "App",
                'last_name' => "Admin",
                'user_groub_id' => 1,
                'email' => 'admin@smartapp.com',
                'contact_no' => "0000000000",
                'user_image' => 'default_image.png'
            ),
            array(
                'username' => 'johnsmith',
                'password' => '24d3c6fe567c74749a2534b1ca2bd3d611528e27',
                'first_name' => "John",
                'last_name' => "Smith",
                'user_groub_id' => 2,
                'email' => 'johnsmith@gmail.com',
                'contact_no' => "0767150199",
                'user_image' => 'default_image.png'
            ),

        );
        DB::table('users')->insert($data);
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
