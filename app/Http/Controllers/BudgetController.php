<?php

namespace App\Http\Controllers;

use App\Model\Device;
use App\Model\DeviceConsumption;
use App\Model\Home;
use App\Model\Room; 
use App\Model\UserGroups;
use App\Model\Users;
use App\Model\BudgetEstimation;
use App\Model\BudgetUnits;
use Carbon\Carbon;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BudgetController extends Controller
{

  protected $url;

  function __construct(UrlGenerator $url)
  {
    $this->url = $url;

    $this->middleware('user_access');
  }

  public function index()
  {
    $general = new \App\Library\General();
    $menu = $general->sideMenu();
    $data['css_files'] = $general->loadCss(1);
    $data['js_files'] = $general->loadJs(2);;
    $data['main_menus'] = $menu['main_menus'];
    $data['sub_menus'] = $menu['sub_menus'];
    $data['users'] = Users::where('user_groub_id', 2)->get();
    $data['user_groups'] = UserGroups::all();
//        $data['positions'] = $general->positionArray();
    $data['user_data'] = Users::find(session()->get('users_id'));
    $data['user_home'] = Home::where('user_id', session()->get('users_id') )
    ->where('is_active','!=',2)
    ->get();
//        dd($data);
    return view('user-contents.budget', $data);
  }

  public function CalculateUnits($billperiod,$Amount){
    $ret = 0.0;
    if($Amount <= (30 + ($billperiod * 2.5))){
      $ret = ($Amount - 30)/ 2.5;
    }else if($Amount <= (60 + ($billperiod * 7.35))){
      $ret = ($Amount - 60 + (2.35 * $billperiod))/ 4.85 ;
    }else if($Amount <= (90 + 25.7 * $billperiod)){
      $ret = ($Amount - 90 + (4.3 * $billperiod))/ 10;
    }else if($Amount <= (480 + 53.45 * $billperiod)){
      $ret = ($Amount - 480 + (57.55 * $billperiod))/ 27.75;
    }else if($Amount <= (480 + 117.45 * $billperiod)){
      $ret = ($Amount - 480 + (74.55 * $billperiod))/ 32;
    }else{
      $ret = ($Amount - 540 + (152.55 * $billperiod))/ 45;
    }
    return round($ret);
  }

  public function CalculateBill($billperiod, $units){

    if($units <= 2* $billperiod ){
      if($units <= $billperiod){
        return 30 + $units * 2.5 ;
      }
      else if($units >  $billperiod && $units <= 2* $billperiod){
        return 60 + $billperiod * 2.5 + ($units  - $billperiod) * 4.85;
      }

    }else{
      if($units <= 3* $billperiod){
        return 90 + 2* $billperiod * 7.85 + ($units  - 2 * $billperiod) * 10;
      }else if($units <= 4* $billperiod){
        return 480 + 2* $billperiod * 7.85 + $billperiod *10.00  + ($units  - 3 * $billperiod) * 27.75 ;

      }else if($units <= 6* $billperiod){
        return 480 + 2* $billperiod * 7.85 + $billperiod *10.00 + $billperiod * 27.75 + ($units  - 4 * $billperiod) * 32.00    ;

      }else{

       return  540 + 2* $billperiod * 7.85 + $billperiod *10.00 + $billperiod * 27.75 + 2* $billperiod * 32.00 + ($units  - 6* $billperiod) * 45.00     ;
     }

   }

 }

 public function saveReport(Request $request){
  $BudgetEstimation = new BudgetEstimation();
  $BudgetEstimation->user_id = session()->get('users_id') ;
  $BudgetEstimation->last_billing_date = $request->last_billing_date;
  $BudgetEstimation->next_billing_date = $request->next_billing_date;
  $BudgetEstimation->budget = $request->budget;
  $BudgetEstimation->budget_units = $request->budget_units;
  $BudgetEstimation->home_id = $request->home_id;
  if($BudgetEstimation->save()){
    //echo $BudgetEstimation->id;

    for ($i=0; !empty($request->input('device_id.'.$i)) ; $i++) { 

      $budget_units = new BudgetUnits();
      $budget_units->budget_est_id = $BudgetEstimation->id;
      $budget_units->device_id = $request->input('device_id.'.$i);
      $budget_units->estimate_unit = $request->input('avg_usage.'.$i);
      $budget_units->avg_usage_day = $request->input('usg_hour.'.$i);

      $budget_units->save();


    }
  }
}

public function regenerateReport(Request $request){
  $BudgetEstimation = new BudgetEstimation();
  $BudgetEstimation->user_id = session()->get('users_id') ;
  $BudgetEstimation->last_billing_date = $request->last_billing_date;
  $BudgetEstimation->next_billing_date = $request->next_billing_date;
  $BudgetEstimation->budget = $request->budget;
  $BudgetEstimation->budget_units = $request->budget_units;
  $BudgetEstimation->home_id = $request->home_id;
  // if($BudgetEstimation->save()){
  //          echo "true";
  // }
  // echo $request->home_id;
  $timeDiff = strtotime($request->next_billing_date) - strtotime($request->last_billing_date);
  $billperiod = $timeDiff / (60 * 60 * 24);
     // echo round((strtotime($nextmeteringdate)- strtotime($lastmeteringdate))) / (60 * 60 * 24));
  //$unitsUsage = $this->CalculateUnits($billperiod,$budget);
  $home = Home::find($request->home_id);
  $rooms = $home->rooms;
      //echo $devices = $home->rooms->devices();
  $est_list = array();
  $check_boxes = array();
  for ($i=0; !empty($request->input('is_reduce.'.$i)) ; $i++) { 
   $check_boxes[$i] =  $request->input('is_reduce.'.$i);
  // echo $check_boxes[$i];
 }

 $estimate_amount = $request->estimate_amount;
 

 $red_hour = 0.5;
 while ( $estimate_amount > $request->budget) {
   $total_units = 0;
   for ($i=0; !empty($request->input('device_id.'.$i)) ; $i++) { 

    if(!in_array( $request->input('device_id.'.$i) , $check_boxes)){
      $est_list[$i] = ['name' => $request->input('device_name.'.$i) , 'device_id' => $request->input('device_id.'.$i) , 'avg_usage' => $request->input('avg_usage.'.$i) , 'usg_hour' => $request->input('usg_hour.'.$i) ] ;
      $total_units += $request->input('avg_usage.'.$i);

    }else{
      $dev_watts = $request->input('avg_usage.'.$i) / $request->input('usg_hour.'.$i) ;
      $red_usage_hr = $request->input('usg_hour.'.$i) - $red_hour;
      if($red_usage_hr <= 0){
        //$red_usage_hr = 0;
        break 2;
      }
      $est_list[$i] = ['name' => $request->input('device_name.'.$i) , 'device_id' => $request->input('device_id.'.$i) , 'avg_usage' => round($red_usage_hr * $dev_watts) , 'usg_hour' => $red_usage_hr ] ;
      $total_units +=  round($red_usage_hr * $dev_watts);
    }


  }

  $estimate_amount = $this->CalculateBill($billperiod, $total_units);
  $red_hour += 0.5;
}

echo json_encode(\View::make('ajax.estimate_usage', compact('est_list','total_units','estimate_amount','BudgetEstimation'))->render());

}


 //  foreach ($rooms as $room) {
 //    foreach ($room->devices as $key => $value) {
 //      if(!$value->is_active){
 //        continue;
 //      }
 //      $avg_usage = DB::select( DB::raw("
 //        SELECT DAY_USAGE.device_id, AVG(tot_usage) avg_usage, AVG(TIME_TO_SEC(timediff))/(60*60) usg_hour FROM ( SELECT device_consumptions.device_id, SUM(device_consumptions.wattph)/1000 tot_usage,SUM(TIMEDIFF(device_consumptions.end_time , device_consumptions.start_time)) timediff ,cast(device_consumptions.start_time as date) startdate FROM `device_consumptions` group BY device_consumptions.device_id , cast(device_consumptions.start_time as date) ORDER BY startdate DESC LIMIT 30 ) DAY_USAGE GROUP BY DAY_USAGE.device_id HAVING DAY_USAGE.device_id = '$value->id' "));
 //      if(count($avg_usage) > 0){
 //       $est_list[$i] = ['name' => $value->name, 'device_id' => $value->id, 'avg_usage' => round($avg_usage[0]->avg_usage) , 'usg_hour' => round($avg_usage[0]->usg_hour) ] ;
 //       $total_units += round($avg_usage[0]->avg_usage);
 //     }else{
 //       $est_list[$i] = ['name' => $value->name, 'device_id' => $value->id, 'avg_usage' =>  ceil(0.01*$value->watts), 'usg_hour' =>10 ] ;
 //       $total_units += ceil(0.01*$value->watts);
 //     }
 //           //
 //     $i++;
 //   }


 // //         // echo $room->devices;
 // }





public function generateReport(Request $request){

  $home = Home::find($request->home);
  $lastmeteringdate = $request->lastmeteringdate;
  $nextmeteringdate = $request->nextmeteringdate;
  $budget = $request->budget;

  $timeDiff = strtotime($nextmeteringdate) - strtotime($lastmeteringdate);
  $billperiod = $timeDiff / (60 * 60 * 24);
     // echo round((strtotime($nextmeteringdate)- strtotime($lastmeteringdate))) / (60 * 60 * 24));
  $unitsUsage = $this->CalculateUnits($billperiod,$budget);

  $BudgetEstimation = new BudgetEstimation();
  $BudgetEstimation->user_id = session()->get('users_id') ;
  $BudgetEstimation->last_billing_date = date("Y-m-d H:i:s", strtotime($lastmeteringdate));
  $BudgetEstimation->next_billing_date = date("Y-m-d H:i:s", strtotime($nextmeteringdate));
  $BudgetEstimation->budget = $budget;
  $BudgetEstimation->budget_units = $unitsUsage;
  $BudgetEstimation->home_id = $request->home;
 // if($BudgetEstimation->save()){
           // echo "true";
  //}

  //$prevmeter1 = date('Y-m-d', strtotime("-1 months", strtotime($lastmeteringdate)));
  //$prevmeter2 = date('Y-m-d', strtotime("-1 months", strtotime($nextmeteringdate)));

  $rooms = $home->rooms;
      //echo $devices = $home->rooms->devices();
  $est_list = array();
  $i = 0;
  $total_units = 0;
  foreach ($rooms as $room) {
    foreach ($room->devices as $key => $value) {
      if(!$value->is_active){
        continue;
      }
      $avg_usage = DB::select( DB::raw("
        SELECT DAY_USAGE.device_id, AVG(tot_usage) avg_usage, AVG(TIME_TO_SEC(timediff))/(60*60) usg_hour FROM ( SELECT device_consumptions.device_id, SUM(device_consumptions.wattph)/1000 tot_usage,SUM(TIMEDIFF(device_consumptions.end_time , device_consumptions.start_time)) timediff ,cast(device_consumptions.start_time as date) startdate FROM `device_consumptions` group BY device_consumptions.device_id , cast(device_consumptions.start_time as date) ORDER BY startdate DESC LIMIT 30 ) DAY_USAGE GROUP BY DAY_USAGE.device_id HAVING DAY_USAGE.device_id = '$value->id' "));
      if(count($avg_usage) > 0){
       $est_list[$i] = ['name' => $value->name, 'device_id' => $value->id, 'avg_usage' => round($avg_usage[0]->avg_usage) , 'usg_hour' => round($avg_usage[0]->usg_hour) ] ;
       $total_units += round($avg_usage[0]->avg_usage);
     }else{
       $est_list[$i] = ['name' => $value->name, 'device_id' => $value->id, 'avg_usage' =>  ceil(0.01*$value->watts), 'usg_hour' =>10 ] ;
       $total_units += ceil(0.01*$value->watts);
     }
           //
     $i++;
   }


         // echo $room->devices;
 }

 $estimate_amount = $this->CalculateBill($billperiod, $total_units);

 echo json_encode(\View::make('ajax.estimate_usage', compact('est_list','total_units','estimate_amount','BudgetEstimation'))->render());


}



}
