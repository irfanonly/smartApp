<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceConsumptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_consumptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('device_id');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->decimal('ampere',10,2);
            $table->decimal('voltage',10,2);
            $table->decimal('wattph',10,2);
            $table->integer('is_active');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        $data = [];
        $days = 5;
        $minutes = 10;

        $deviceIds = [1, 2, 3, 4];
        foreach ($deviceIds as $deviceId) {
            $date = \Carbon\Carbon::parse(\Carbon\Carbon::now()->format("Y-m-d"));
            $endDate = \Carbon\Carbon::parse($date->addDays($days)->format("Y-m-d"));
            $date->addDays(-2 * $days);
            while ($date->lt($endDate)) {
                $amp=$this->float_rand(5, 15,2);
                $volt=$this->float_rand(220, 240,2);
                $wh=$amp*$volt;
                $data[] = [
                    "device_id" => $deviceId,
                    "start_time" => $date->format("Y-m-d H:i:s"),
                    "end_time" => $date->addMinutes($minutes)->format("Y-m-d H:i:s"),
                    "ampere" =>$amp ,
                    "voltage" => $volt,
                    "wattph" => $wh,
                    "is_active" => 1,
                ];
            }
        }

        DB::table('device_consumptions')->insert($data);


    }

    function float_rand($Min, $Max, $round = 0)
    {
        //validate input
        if ($Min > $Max) {
            $min = $Max;
            $max = $Min;
        } else {
            $min = $Min;
            $max = $Max;
        }
        $randomfloat = $min + mt_rand() / mt_getrandmax() * ($max - $min);
        if ($round > 0)
            $randomfloat = round($randomfloat, $round);

        return $randomfloat;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_consumptions');
    }
}
