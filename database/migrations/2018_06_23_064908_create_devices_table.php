<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unique_id');
            $table->integer('room_id');
            $table->string('name');
            $table->integer('is_active');
            $table->integer('status');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        $data = array(
            array(
                'unique_id' => uniqid(),
                'room_id' => 1,
                'name' => "Device 1",
                'is_active' => 1,
                'status' => 0,
            ),
            array(
                'unique_id' => uniqid(),
                'room_id' => 1,
                'name' => "Device 2",
                'is_active' => 1,
                'status' => 0,
            ),
            array(
                'unique_id' => uniqid(),
                'room_id' => 2,
                'name' => "Device 3",
                'is_active' => 1,
                'status' => 0,
            ),
            array(
                'unique_id' => uniqid(),
                'room_id' => 2,
                'name' => "Device 4",
                'is_active' => 1,
                'status' => 0,
            ),
        );
        DB::table('devices')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
