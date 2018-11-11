<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('user_access', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_group_id');
            $table->bigInteger('side_menu_id');
        });
        $data = array(
            array('user_group_id'=>1,'side_menu_id'=>1),
            array('user_group_id'=>1,'side_menu_id'=>2),
            array('user_group_id'=>1,'side_menu_id'=>3),


            array('user_group_id'=>2,'side_menu_id'=>3),


            
        );
        DB::table('user_access')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_access');
    }
}
