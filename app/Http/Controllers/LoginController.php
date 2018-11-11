<?php

namespace App\Http\Controllers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use App\Http\Requests;
use Cookie;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Validator;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LoginController extends Controller
{

    protected $url;

    function __construct(UrlGenerator $url)
    {
        $this->url = $url;
    }

    public function index()
    {

        if (session()->get('LoggedIn')) {
            return redirect('device');
        } else {
            return view('login');
        }

    }

    public function login(Request $request)
    {
        $user = \App\Model\Users::where('username', $request->user_name)
            ->where('password', sha1($request->password))
            ->where('is_delete', 0)
            ->first();
        if ($user) {
            $user_data = array(
                'users_id' => $user->id,
                'name' => $user->first_name . ' ' . $user->last_name,
                'position' => $user->UserGroups->name,
                'user_image' => $user->user_image,
                'username' => $user->username,
                'user_group' => $user->user_groub_id,
                'email' => $user->email,
                'contact_no' => $user->contact_no,
                'LoggedIn' => true
            );
            foreach ($user_data as $key => $value) {
                session()->put($key, $value);
            }
            return redirect($this->url->to('device'));
        } else {
            return redirect($this->url->to('/'));
        }
    }



    public function validateUsername(Request $request)
    {
        $obj = \App\Model\Users::where('username', $request->user_name)
            ->where('is_delete', 0)
            ->first();
        if ($obj) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    public function validateLogin(Request $request)
    {
        $obj = \App\Model\Users::where('username', $request->user_name)
            ->where('password', sha1($request->password))
            ->where('is_delete', 0)
            ->first();
        if ($obj) {
            echo 'true';
        } else {
            echo 'false';
        }
    }



    public function logout()
    {
        session()->flush();
        return redirect('/');
    }



}
