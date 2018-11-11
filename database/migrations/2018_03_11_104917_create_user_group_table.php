<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            $this->down();
        Schema::create('user_group', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',30);
        });
        $data = array(
            array('name'=>'Admin'),
            array('name'=>'Customer'),
        );
        DB::table('user_group')->insert($data);
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_group');
    }
}
