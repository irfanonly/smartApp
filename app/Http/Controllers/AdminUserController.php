<?php

namespace App\Http\Controllers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use App\Http\Requests;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AdminUserController extends Controller {

    protected $url;

    function __construct(UrlGenerator $url) {
        $this->url = $url;
        $this->middleware('user_access');
    }

    public function index() {
        $general = new \App\Library\General();
        $menu = $general->sideMenu();
        $data['css_files'] = $general->loadCss(1);
        $data['js_files'] = $general->loadJs(2);
;
        $data['main_menus'] = $menu['main_menus'];
        $data['sub_menus'] = $menu['sub_menus'];
        $data['users'] = $this->getUserList();
        $data['user_groups'] = \App\Model\UserGroups::all();
        $data['user_data']= \App\Model\Users::find(session()->get('users_id'));
        return view('admin-cotents.user_view', $data);
    }

    public function store(Request $request) {
        $obj = $request->id ? \App\Model\Users::find($request->id) : new \App\Model\Users;
        $obj->username = $request->user_name;
        $obj->password = sha1($request->password);
        $obj->first_name = $request->first_name;
        $obj->last_name = $request->last_name;
        $obj->user_groub_id = $request->user_group_id;
        $obj->contact_no = $request->contact_no;
        $obj->user_image="default_image.png";
        $obj->email = $request->email;
        if ($obj->save()) {
            $result['response'] = true;
            $result['data'] = $this->getUserList();
        } else {
            $result['response'] = FALSE;
        }
        echo json_encode($result);
    }

    public function update(Request $request, $id) {
        
    }

    public function updateProfile(Request $request) {

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
            $result['data']=$obj;
        } else {
            $result['response'] = FALSE;
        }
        echo json_encode($result);
    }

    public function getUserList() {
        $data = \App\Model\Users::select('id', 'username', 'first_name', 'last_name', 'user_groub_id', 'contact_no', 'email')
                ->with('UserGroups')
                ->where('is_delete', 0)
                ->get();
        return $data;
    }

    public function edit($id) {
        $data = \App\Model\Users::find($id);
        if ($data) {
            $result['response'] = true;
            $result['data'] = $data;
        } else {
            $result['response'] = false;
        }
        echo json_encode($result);
    }

    public function destroy($id) {
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





    public function usernameExistCheck(Request $request) {
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

    public function userPasswordCheck(Request $request) {
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

    public function passwordChange(Request $request) {
        $obj = \App\Model\Users::where('id', $request->user_id)
                ->where('password', sha1($request->old_password))
                ->where('is_delete', 0)
                ->first();
        if($obj){
            $obj->password=sha1($request->new_password);
            $obj->save();
            $result['response']=true;
        }
        else{
           $result['response']=FALSE; 
        }
        echo json_encode($result);
    }



}
