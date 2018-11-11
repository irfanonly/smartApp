<?php

namespace App\Http\Controllers;

use App\Model\Device;
use App\Model\DeviceConsumption;
use App\Model\Home;
use App\Model\Room;
use App\Model\UserGroups;
use App\Model\Users;
use App\Model\BudgetEstimation;
use App\Model\Appliances;
use App\Model\CalculatedValues;
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

class UsageController extends Controller
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
        //$data['user_appliances'] = Appliances::all();
//        dd($data);
        //$data['last_estimation'] =  BudgetEstimation::where('user_id',session()->get('users_id'))
        //->orderBy('next_billing_date', 'desc')->first();

        $data['user_home'] = Home::where('user_id', session()->get('users_id') )
        ->where('is_active','!=',2)
        ->get();

        $current_usage_home = BudgetEstimation::where('user_id',session()->get('users_id'))->whereRaw('id IN (select MAX(id) FROM budget_estimation GROUP BY home_id)')->get();
        $current_usage = array();
        $i = 0;
        foreach ($current_usage_home as $key => $value) {
           $current_usage[$i] = DB::select( DB::raw("
               select homes.name AS HomeName, budget_estimation.* , CN.consump from budget_estimation 
               left join 
               (select rooms.home_id, SUM( CASE WHEN (device_consumptions.start_time >= '$value->last_billing_date' AND device_consumptions.start_time <= '$value->next_billing_date') THEN device_consumptions.wattph ELSE 0 END)/1000 as consump from device_consumptions
               left join devices on devices.id = device_consumptions.device_id
               left join rooms on rooms.id = devices.room_id
               where rooms.home_id = '$value->home_id' GROUP BY rooms.home_id ) AS CN on CN.home_id = budget_estimation.home_id
               left join homes on homes.id = budget_estimation.home_id where budget_estimation.home_id = '$value->home_id'"));
           $i++;
       }
       $data['current_usage']  = $current_usage;
       return view('user-contents.usage', $data);
   }

   public function retriveUsageHistory(Request $request){
    $home = Home::find($request->home);
    $fromdate = $request->fromdate;
    $todate = $request->todate;

   // echo empty($fromdate);

    if( empty($fromdate) && empty($todate) ){
        //echo "1";
        $usage_list = DB::select( DB::raw("
           select devices.name, devices.id, cast(device_consumptions.start_time as date) startdate
            ,  round(SUM( wattph)) as wattshour
           ,  round(SUM( wattph)/1000) as consump from device_consumptions
           left join devices on devices.id = device_consumptions.device_id
           left join rooms on rooms.id = devices.room_id
           WHERE rooms.home_id = '$request->home'
           GROUP BY devices.id, devices.name, cast(device_consumptions.start_time as date)"));

       echo json_encode(\View::make('ajax.retrive_usage', compact('usage_list'))->render());
    }
    elseif(!empty($fromdate) && empty($todate) ){
        //echo "2";
        $date = strtotime($fromdate);
        $fromdate = date('Y-m-d', $date);
        //echo $fromdate;
        $usage_list = DB::select( DB::raw("
           select devices.name, devices.id, cast(device_consumptions.start_time as date) startdate
           ,  round(SUM( wattph)) as wattshour
           ,  round(SUM( wattph)/1000) as consump from device_consumptions
           left join devices on devices.id = device_consumptions.device_id
           left join rooms on rooms.id = devices.room_id
           WHERE rooms.home_id = '$request->home' and device_consumptions.start_time >= '$fromdate'
           GROUP BY devices.id, devices.name, cast(device_consumptions.start_time as date)"));

        echo json_encode(\View::make('ajax.retrive_usage', compact('usage_list'))->render());
    }else{

       // $date = strtotime($fromdate);
        $fromdate = date('Y-m-d', strtotime($fromdate));
        $todate = date('Y-m-d', strtotime($todate));
        //echo $fromdate;
        $usage_list = DB::select( DB::raw("
           select devices.name, devices.id, cast(device_consumptions.start_time as date) startdate
          ,  round(SUM( wattph)) as wattshour
           ,  round(SUM( wattph)/1000) as consump from device_consumptions
           left join devices on devices.id = device_consumptions.device_id
           left join rooms on rooms.id = devices.room_id
           WHERE rooms.home_id = '$request->home' and device_consumptions.start_time >= '$fromdate' and device_consumptions.start_time <= '$todate'
           GROUP BY devices.id, devices.name, cast(device_consumptions.start_time as date)"));

        echo json_encode(\View::make('ajax.retrive_usage', compact('usage_list'))->render());
    }
    
}

public function getGraphRecords(Request $request){
    $year = $request->datepicker ;
    $consumptions = DeviceConsumption::where('device_consumptions.is_active', 1)
    ->leftJoin('devices', 'devices.id', '=', 'device_consumptions.device_id')
    ->leftJoin('rooms', 'rooms.id', '=', 'devices.room_id')
    ->leftJoin('homes', 'homes.id', '=', 'rooms.home_id')-> where('homes.user_id',session()->get('users_id') )
    ->select(DB::raw('ROUND(sum(wattph)/1000)  A, YEAR(device_consumptions.start_time) year, MONTH(device_consumptions.start_time) month'))
    ->groupby('year','month')->having('year',$year)->get();
    $chart_data = '';
    foreach ($consumptions as $key => $value) {
       $chart_data .= ',{ "y":"'.$value["year"].'-'.$value["month"].'", "a":'.$value["A"].'} ';
   }


       //$graphRecord = $consumptions->select('A')->get();
   if( strlen($chart_data) > 1){
    return "[". substr($chart_data, 1)."]";
}else{
    return "";
}

}

}
