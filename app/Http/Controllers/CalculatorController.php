<?php

namespace App\Http\Controllers;

use App\Model\Device;
use App\Model\DeviceConsumption;
use App\Model\Home;
use App\Model\Room;
use App\Model\UserGroups;
use App\Model\Users;
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

class CalculatorController extends Controller
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
        $data['user_appliances'] = Appliances::all();
//        dd($data);
        return view('admin-cotents.calculator', $data);
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



public function calculation(Request $request){

        //foreach($request as $inputName => $inputValue){
        //echo $inputName; //This is the name of an input field
        //echo $inputValue; //This is the value of the input field 

    //}
        //$input = $request->all();

    $totalunits=0.0;
    for ($i=0; !empty($request->input('id.'.$i)) ; $i++) { 

        if(!empty($request->input('units_month.'.$i))){
            $appliance = new CalculatedValues();
            $appliance->appliance_id = $request->input('id.'.$i); 
            $appliance->no_of_app = $request->input('no_of_app.'.$i);
            $appliance->avg_usage = $request->input('usage_hrs.'.$i);
            $appliance->app_units_month = $request->input('units_month.'.$i);
            $totalunits += $appliance->app_units_month;

            if($appliance->save()){

            }

        }
    }



    $calculatebill = $this->CalculateBill(30, $totalunits);

    return compact('totalunits','calculatebill');
}




}
