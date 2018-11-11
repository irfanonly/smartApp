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

class HomeController extends Controller
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
        return view('admin-cotents.home', $data);
    }
    


}
