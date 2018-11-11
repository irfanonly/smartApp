<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSideMenuTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('side_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('menu_order');
            $table->bigInteger('menu_category');
            $table->string('menu_name', 40);
            $table->string('menu_id', 40);
            $table->string('menu_icon', 50)->nullable();
            $table->string('menu_url', 100)->nullable();
        });
        $data = array(
            array('menu_order' => 2, 'menu_category' => 0, 'menu_name' => "Admin", 'menu_id' => "main_menu_admin", 'menu_icon' => "fa fa-lock", 'menu_url' => null),
            array('menu_order' => 1, 'menu_category' => 1, 'menu_name' => "Users", 'menu_id' => "sub_menu_manage_users", 'menu_icon' => null, 'menu_url' => 'user'),
            array('menu_order' => 1, 'menu_category' => 0, 'menu_name' => "Device", 'menu_id' => "main_menu_device", 'menu_icon' => 'fa fa-desktop', 'menu_url' => 'device'),

        );
        DB::table('side_menu')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('side_menu');
    }

}
