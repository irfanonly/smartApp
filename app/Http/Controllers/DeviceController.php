<?php

namespace App\Http\Controllers;

use App\Model\Device;
use App\Model\DeviceConsumption;
use App\Model\Home;
use App\Model\Room;
use App\Model\UserGroups;
use App\Model\Users;
use Carbon\Carbon;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DeviceController extends Controller
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
//        dd($data);
        return view('admin-cotents.device', $data);
    }

    function getHomesUser(Request $request)
    {
        $homes = $this->getHomesByUserId($request->id);
        echo json_encode(\View::make('ajax.homelist', compact('homes'))->render());
    }

    function getRoomsHome(Request $request)
    {
        $home=Home::find($request->id);
        $rooms = $this->getRoomsByHomeId($request->id);
        echo json_encode(\View::make('ajax.roomlist', compact('rooms','home'))->render());
    }

    function getDevicesRoom(Request $request)
    {
        $room=Room::find($request->id);
        $devices = $this->getDevicesByRoomId($request->id);
        $result['data'] = \View::make('ajax.devicelist', compact('devices','room'))->render();
        $result['devices'] = $devices;
        echo json_encode($result);
    }

    function getHomesByUserId($userId)
    {
        return Home::where('user_id', $userId)
            ->where('is_active','!=',2)
            ->get();
    }

    function getRoomsByHomeId($homeID)
    {
        return Room::where('home_id', $homeID)
            ->where('is_active','!=',2)
            ->get();
    }

    function getDevicesByRoomId($roomID)
    {
        return Device::where('room_id', $roomID)
            ->where('is_active','!=',2)
            ->get();
    }

    function insertUpdateHome(Request $request)
    {
        $insert = ($request->id == false);
        $home = !$insert ? Home::find($request->id) : new Home();
        $home->name = !empty($request->name) ? $request->name : $home->name ?: "";

        if ($insert) {
            $home->user_id = $request->user_id;
            $home->is_active = 1;
        } else {
            $home->is_active = $request->is_active;
        }
        if ($home->save()) {
            if($request->is_active == 2){
                $home->delete();
            }
            $result['response'] = true;
            $homes = $this->getHomesByUserId($home->user_id);
            $result['data'] = \View::make('ajax.homelist', compact('homes'))->render();
        } else {
            $result['response'] = FALSE;
        }
        echo json_encode($result);

    }

    function insertUpdateRoom(Request $request)
    {
        $insert = ($request->id == false);
        $room = !$insert ? Room::find($request->id) : new Room();
        $room->name = !empty($request->name) ? $request->name : $room->name ?: "";


        if ($insert) {
            $home=Home::find($request->home_id);
            $room->home_id = $request->home_id;
            $room->is_active = 1;
        } else {
            $home=$room->home;
            $room->is_active = $request->is_active;
        }

        if(empty($home)){
            $result['response'] = FALSE;
            echo json_encode($result);
            return;
        }
        if ($room->save()) {
            if($request->is_active == 2){
                $room->delete();
            }
            $result['response'] = true;
            $rooms = $this->getRoomsByHomeId($room->home_id);
            $result['data'] = \View::make('ajax.roomlist', compact('rooms','home'))->render();
        } else {
            $result['response'] = FALSE;
        }
        echo json_encode($result);

    }

    function insertUpdateDevice(Request $request)
    {
        $insert = ($request->id == false);
        $device = !$insert ? Device::find($request->id) : new Device();
        $device->name = !empty($request->name) ? $request->name : $device->name ?: "";
        $device->watts = $request->watts;
        $device->limit_value = $request->limit_value;
        $device->suport_device = $request->suport_device;

        if ($insert) {

            $deviceUser = Users::find($request->user_id);

            $validator=Validator::make($request->all(),[
                "name"=>'required',
                "suport_device"=> 'required',
                "limit_value"=> 'required|integer',
                "watts" => 'required|integer'
            ]);
            if($validator->fails()){
                $result['response'] = FALSE;
                $result['data'] = $validator->errors()->first();
                echo json_encode($result);
                return;
            }
            $host_power = env('WEB_API_POWER');
            $client = new Client();
            $user = Users::find(session()->get('users_id'));
            //echo "api call";
            $res = $client->request('POST', $host_power.'register_device.php', [
                'query' => [ 'device_name' => $device->name,
                'suport_device' => $device->suport_device,
                'limit_value' => $device->limit_value,
                'created_by' => $deviceUser->email,
                'watt' => ''.$device->watts ]
            ]);
             //$statusCode =  $res->getStatusCode();
             //echo $res->getBody();
             $ret = json_decode((string)$res->getBody()) ;
             if($ret->status == '200'){
                $device->unique_id = $ret->id;
                //$device->save();
             }else{
                $result['response'] = FALSE;
                $result['data'] = $ret->message;
                echo json_encode($result);
                return;
             }

            $room=Room::find($request->room_id);
           // $device->unique_id = $request->unique_id;
            $device->room_id = $request->room_id;
            $device->is_active = 1;
            $device->status = 1;
        } else {
            $room=$device->room;
            $device->is_active = $request->is_active;
            $device->status = $request->status;
        }
        if(empty($room)){
            $result['response'] = FALSE;
            $result['data'] = "Room is Empty";
            echo json_encode($result);
            return;
        }
        if ($device->save()) {
            if($request->is_active == 2){
                $device->delete();
            }

            $result['response'] = true;
            $devices = $this->getDevicesByRoomId($device->room_id);
            $result['data'] = \View::make('ajax.devicelist', compact('devices','room'))->render();
            $result['devices'] = $devices;
        } else {
            $result['response'] = FALSE;
            $result['data'] = "Cannot Save";
        }
        echo json_encode($result);

    }

    function getDataForGraph2(Request $request){
        
        $device=Device::find($request->id);
        $host_power = env('WEB_API_POWER');
        $headers = ['Content-Type' => 'application/x-www-form-urlencoded'];
        $client = new Client();
        $res = $client->request('GET', $host_power.'get_result.php', [
            'query' => [
                'device_id' => $device->unique_id
            ]
             
        ]);
        $ret = json_decode((string)$res->getBody()) ;
             if($ret->status == '200'){
                //$device->unique_id = $ret->id;
                //$device->save();
             }else{
                $result['response'] = FALSE;
                $result['data'] = $ret->message;
                echo json_encode($result);
                return;
             }
            $chart_data = '';
            $chart_data_amount = '';
            $today = date("Y-m");
            $count = count($ret->result);
            $effectiveDate = date('Y-m', strtotime("-".($count-1)." months", strtotime($today)));

            foreach ($ret->result as $value){
                //$result["graph_data"] = $value->usage_time;
                $chart_data .= ',{ "y":"'.$effectiveDate.'", "a":'.$value->usage_time.',"b":'.$value->wastage_time.'} ';
                $chart_data_amount .= ',{ "y":"'.$effectiveDate.'", "a":'.$value->usageCharge.',"b":'.$value->wastageCharge.'} ';

                $effectiveDate = date('Y-m', strtotime("+1 months", strtotime($effectiveDate)));
            }


       //$graphRecord = $consumptions->select('A')->get();
        if( strlen($chart_data) > 1){
            $result["graph_data"] = "[". substr($chart_data, 1)."]";
        }else{
            $result["graph_data"] = "";
        }

        if( strlen($chart_data_amount) > 1){
            $result["graph_data_amount"] = "[". substr($chart_data_amount, 1)."]";
        }else{
            $result["graph_data_amount"] = "";
        }

        $client2 = new Client();
        $res2 = $client2->request('POST', $host_power.'get_by_month.php', [
            'query' => [
                'device_id' => $device->unique_id
            ]
             
        ]);
        $ret2 = json_decode((string)$res2->getBody()) ;
        $result["graph_curr_usage"] = $ret2;
             if($ret2->status == '200'){
                //$device->unique_id = $ret->id;
                //$device->save();
             }else{
               // $result['response'] = FALSE;
               // $result['data'] = $ret->message;
               // echo json_encode($result);
               // return;
             }

        $result['data'] = \View::make('ajax.graph-device', compact('device'))->render();
        //$result["graph_data"]=$ret->result;

        //$result["average"]=2350;
        echo json_encode($result);

    }

    function getDataForGraph(Request $request)
    {
        $type = $request->type;
        $points = 10;
        $time = $request->end_time ? Carbon::parse($request->end_time) : Carbon::now();
        $data = [];
        $device=Device::find($request->id);
//        DB::enableQueryLog();
        $consumptions = DeviceConsumption::where('device_id', $request->id)
            ->where('is_active', 1)
            ->orderBy('end_time', 'DESC');
        if ($type == "minutes") {
            $consumptions = $consumptions->where('end_time', '<', $time->format("Y-m-d H:i:s"))
                ->limit(10)
                ->get();
            foreach ($consumptions as $consumption) {
                $data[] = [
                    "name" => Carbon::parse($consumption->start_time)->format("h:i") . "-" . Carbon::parse($consumption->end_time)->format("h:i"),
                    "ampere" => $consumption->ampere,
                    "voltage" => $consumption->voltage,
                    "wattph" => $consumption->wattph
                ];
            }

        } elseif ($type == "hours") {
            $endTime = $time->addHour()->format("Y-m-d H:00:00");
            $startTime = $time->addHours(-1 * $points)->format("Y-m-d H:00:00");
            $consumptions = $consumptions->where('start_time', '>=', $startTime)
                ->where('end_time', '<=', $endTime)->get();
            foreach ($consumptions as $consumption) {
                $h = Carbon::parse($consumption->start_time);
                $key = $h->format("H");
                if (!array_key_exists($key, $data)) {
                    $data[$key] = [
                        "name" => $h->format("g") . $h->format("A") . "-" . $h->addHour()->format("g") . $h->format("A"),
                        "ampere" => 0.00,
                        "voltage" => 0.00,
                        "wattph" => 0.00,
                        "count" => 0
                    ];
                }
                $data[$key]["ampere"] += $consumption->ampere;
                $data[$key]["voltage"] += $consumption->voltage;
                $data[$key]["wattph"] += $consumption->wattph;
                $data[$key]["count"]++;
            }
            foreach ($data as &$value) {
                $value["ampere"] = number_format($value["ampere"] / $value["count"], "2", ".", "");
                $value["voltage"] = number_format($value["voltage"] / $value["count"], "2", ".", "");
//                $value["wattph"]=number_format($value["wattph"]/$value["count"],"2",".","");
                $value["wattph"] = number_format($value["ampere"] * $value["voltage"], "2", ".", "");
                unset($value["count"]);
            }

        } elseif ($type == "days") {
            $endTime = $time->addDay()->format("Y-m-d 00:00:00");
            $startTime = $time->addDays(-1 * $points)->format("Y-m-d 00:00:00");
            $consumptions = $consumptions->where('start_time', '>=', $startTime)
                ->where('end_time', '<=', $endTime)->get();
            foreach ($consumptions as $consumption) {
                $d = Carbon::parse($consumption->start_time);
                $key = $d->format("d");
                if (!array_key_exists($key, $data)) {
                    $data[$key] = [
                        "name" => $d->format("Y-m-d"),
                        "ampere" => 0.00,
                        "voltage" => 0.00,
                        "wattph" => 0.00,
                        "count" => 0
                    ];
                }
                $data[$key]["ampere"] += $consumption->ampere;
                $data[$key]["voltage"] += $consumption->voltage;
                $data[$key]["wattph"] += $consumption->wattph;
                $data[$key]["count"]++;
            }
            foreach ($data as &$value) {
                $value["ampere"] = number_format($value["ampere"] / $value["count"], "2", ".", "");
                $value["voltage"] = number_format($value["voltage"] / $value["count"], "2", ".", "");
//                $value["wattph"]=number_format($value["wattph"]/$value["count"],"2",".","");
                $value["wattph"] = number_format($value["ampere"] * $value["voltage"], "2", ".", "");
                unset($value["count"]);
            }

        }
        $general = new \App\Library\General();
        $timeArray=$general->timeArray();
        $result['data'] = \View::make('ajax.graph-device', compact('device','timeArray','type'))->render();
        $result["graph_data"]=array_reverse(array_values($data));

        $result["average"]=2350;
        echo json_encode($result);

//        $general = new \App\Library\General();
//        $menu = $general->sideMenu();
//        $data['css_files'] = $general->loadCss(1);
//        $data['js_files'] = $general->loadJs(2);;
//        $data['main_menus'] = $menu['main_menus'];
//        $data['sub_menus'] = $menu['sub_menus'];
//        $data['users'] = Users::where('user_groub_id', 2)->get();
//        $data['user_groups'] = UserGroups::all();
//        $data['positions'] = $general->positionArray();
//        $data['user_data'] = Users::find(session()->get('users_id'));
////        return view('ajax.graph-device', $data);
//        $result['data'] = \View::make('ajax.graph-device', $data)->render();
//        dd($result);

    }


    public function store(Request $request)
    {
        $obj = $request->id ? \App\Model\Users::find($request->id) : new \App\Model\Users;
        $obj->username = $request->user_name;
        $obj->password = sha1($request->password);
        $obj->first_name = $request->first_name;
        $obj->last_name = $request->last_name;
        $obj->user_groub_id = $request->user_group_id;
        $obj->contact_no = $request->contact_no;
        $obj->user_image = "default_image.png";
        $obj->email = $request->email;
        if ($obj->save()) {
            $result['response'] = true;
            $result['data'] = $this->getUserList();
        } else {
            $result['response'] = FALSE;
        }
        echo json_encode($result);
    }

    public function update(Request $request, $id)
    {

    }

    public function updateProfile(Request $request)
    {

        $image = $request->image_name;
        if (!empty($_FILES['image'])) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $image = time() . "_" . $request->user_id . '.' . $ext;
            move_uploaded_file($_FILES["image"]["tmp_name"], 'public/images/users/' . $image);
        }
        $obj = \App\Model\Users::find($request->user_id);
        $obj->first_name = $request->first_name;
        $obj->last_name = $request->last_name;
        $obj->user_image = $image;
        $obj->contact_no = $request->contact_no;
        $obj->email = $request->email;
        if ($obj->save()) {
            $result['response'] = true;
            $result['data'] = $obj;
        } else {
            $result['response'] = FALSE;
        }
        echo json_encode($result);
    }

    public function getUserList()
    {
        $data = \App\Model\Users::select('id', 'username', 'first_name', 'last_name', 'user_groub_id', 'contact_no', 'email')
            ->with('UserGroups')
            ->where('is_delete', 0)
            ->get();
        return $data;
    }

    public function edit($id)
    {
        $data = \App\Model\Users::find($id);
        if ($data) {
            $result['response'] = true;
            $result['data'] = $data;
        } else {
            $result['response'] = false;
        }
        echo json_encode($result);
    }

    public function destroy($id)
    {
        $obj = \App\Model\Users::find($id);
        $obj->is_delete = 1;
        if ($obj->save()) {
            $result['response'] = true;
            $result['data'] = $this->getUserList();
        } else {
            $result['response'] = false;
        }
        echo json_encode($result);
    }


    public function usernameExistCheck(Request $request)
    {
        if ($request->old_user_name != $request->user_name) {
            $obj = \App\Model\Users::where('username', $request->user_name)
                ->where('is_delete', 0)
                ->first();
            if ($obj) {
                echo 'false';
            } else {
                echo 'true';
            }
        } else {
            echo 'true';
        }
    }

    public function userPasswordCheck(Request $request)
    {
        $obj = \App\Model\Users::where('id', $request->user_id)
            ->where('password', sha1($request->old_password))
            ->where('is_delete', 0)
            ->first();
        if ($obj) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    public function passwordChange(Request $request)
    {
        $obj = \App\Model\Users::where('id', $request->user_id)
            ->where('password', sha1($request->old_password))
            ->where('is_delete', 0)
            ->first();
        if ($obj) {
            $obj->password = sha1($request->new_password);
            $obj->save();
            $result['response'] = true;
        } else {
            $result['response'] = FALSE;
        }
        echo json_encode($result);
    }


}
