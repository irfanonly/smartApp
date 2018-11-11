<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Model\Device;
use App\Model\DeviceConsumption;
use App\Model\Home;
use App\Model\Room;
use App\Model\UserGroups;
use App\Model\Users;
use App\Model\Appliances;
use App\Model\CalculatedValues;
use App\Model\BudgetEstimation;
use Carbon\Carbon;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $current_usage_home = BudgetEstimation::whereRaw('id IN (select MAX(id) FROM budget_estimation GROUP BY home_id) and next_billing_date >= "2018-06-01"')->get();
        
        foreach ($current_usage_home as $key => $value) {
           
           $current_usage = DB::select( DB::raw("
               select users.email,devices.unique_id, devices.name AS deviceName, users.first_name,users.last_name, homes.name AS HomeName, budget_units.* , CN.consump from  budget_units  
left join budget_estimation on budget_estimation.id = budget_units.budget_est_id
               left join 
               (select device_id, SUM( CASE WHEN (device_consumptions.start_time >= '$value->last_billing_date' AND device_consumptions.start_time <= '$value->next_billing_date') THEN device_consumptions.wattph ELSE 0 END)/1000 as consump from device_consumptions
               
                GROUP BY device_consumptions.device_id) AS CN on CN.device_id = budget_units.device_id
                left join devices on devices.id = CN.device_id
               left join rooms on rooms.id = devices.room_id
               left join homes on homes.id = budget_estimation.home_id 
               left join users on users.id = homes.user_id
               where 
               budget_estimation.id = '$value->id' AND
               budget_units.estimate_unit < CN.consump
               "));

                  

       

        $i = 0;
        foreach ($current_usage as $key1 => $value1) {
            echo 'Sending mail...'.$value1->email."\n" ;
         //$messages = 'Hi '.$value->first_name.' '.$value->last_name.',</br>';
            $email = $value1->email;
         $homeName = $value1->HomeName;
         $deviceName = $value1->deviceName ;
         $unique_id = $value1->unique_id;
          // Mail::raw($messages, function ($message) use($homeName) {
           // $message->to('mamirfan92@gmail.com')->subject('Usage Exceeded - '.$homeName);
            // });
         $data['usage_detail'] =  $value1;
           Mail::send('emails.usage', $data , function ($message) use($homeName, $deviceName, $unique_id,$email){

            $message->to($email)->cc('info.smartapp2@gmail.com')->subject($deviceName.'('.$unique_id.') usage is exceeded in '.$homeName);
            });
           $i++;
       }
       }


        })->everyMinute();


         $schedule->command('inspire')
                 ->everyMinute();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    
}
