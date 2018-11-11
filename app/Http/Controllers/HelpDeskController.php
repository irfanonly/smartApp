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
use App\Model\BudgetEstimation;
use Carbon\Carbon;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Mail;
use GuzzleHttp\Client;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class HelpDeskController extends Controller
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
        return view('user-contents.help', $data);
    }
    
    public function sendHelp(Request $request){
        $subject = $request->subject;
        $messages = $request->message;

        $user = Users::find(session()->get('users_id'));
        $sendermail = $user->email;

        //mail("info.smartapp2@gmail.com", $subject, $message);
        //Mail::raw('emails.reminder', function ($m) use ($user) {
          //  $m->from('info.smartapp2@gmail.com', 'Your Application');

            //$m->to('info.smartapp2@gmail.com', $user->name)->subject($subject);
        //});

        Mail::raw($messages, function ($message) use ($user,$subject) {
            $message->to('info.smartapp2@gmail.com')->cc($user->email)->subject($subject.' - '.$user->username);
        });

        echo true;
    }


    public function SendNotification(){

        $host_power = env('WEB_API_POWER');
        $headers = ['Content-Type' => 'application/x-www-form-urlencoded'];
        $client = new Client();
        $res = $client->request('GET', $host_power.'get_by_month.php', [
            'query' => [
                'device_id' => 'DIV1111'
            ]
             
        ]);
        $body = $res->getBody();
// Implicitly cast the body to a string and echo it
//echo $body;
// Explicitly cast the body to a string
$stringBody = (string) $body;
// Read 10 bytes from the body
$tenBytes = $body->read(10);
// Read the remaining contents of the body as a string
$k =  json_decode($stringBody) ;
echo $k->status;
//echo var_dump($body );
    }

}
