@extends('admin-layouts.main')
@section('headers')
<title>SmartApp | User</title>
@foreach($css_files as $css_file)
<link rel="stylesheet" type="text/css" id="theme" href="{{ $css_file}}"/>
@endforeach

@endsection 
@section('content')
<style>
    .div-margintop{
        margin-top:10px;
    }
    .close-btn{
        display: block;
        float: left;
        width: 28px;
        height: 28px;
        text-align: center;
        line-height: 15px;
        color: #22262e;
        border: 1px solid #BBB;
        -moz-border-radius: 20%;
        -webkit-border-radius: 20%;
        border-radius: 20%;
        margin-left: 3px;
        -webkit-transition: all 200ms ease;
        -moz-transition: all 200ms ease;
        -ms-transition: all 200ms ease;
        -o-transition: all 200ms ease;
        transition: all 200ms ease;
    }
</style>
<div class="contentpanel" style="overflow-x: hidden;">

    <ol class="breadcrumb breadcrumb-quirk">
        <li><a href="{{URL::to('/user')}}"><i class="fa fa-desktop"></i> ADMIN</a></li>
        <li class="active">MANAGE USERS</li>
    </ol>

    <div class="panel">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <h1 class="panel-title col-md-10"><strong>Manage</strong> Users</h1>
                    <button onclick="close_btn()"  class="pull-right close-btn"><i class="fa fa-times" aria-hidden="true"></i> </button>
                      @if(session()->get('user_group')==1)
                    <button onclick="reset_form()" data-toggle="modal" data-target="#myModal" class="btn-sm btn-success pull-right  "><i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
                      @endif
                </div>
            </div>
            <div class="panel-body" >
                <div class="table-responsive" style="overflow-x: hidden;">
                    <table id="dataTable1" class="table table-bordered table-striped-col" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>User Name</th>
                                <th>User Group</th>
                                <th>Contact NO</th>
                                <th>Email</th>
                                @if(session()->get('user_group')==1)
                                <th></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- panel -->
</div><!-- contentpanel -->
<div class="modal bounceIn animated" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">User Form</h4>
            </div>
            <div class="modal-body">
                <form id="formInput"  class="form-horizontal" autocomplete="off">
                    <input type="hidden" id="id" name="id"/>
                    <input type="hidden" id="_token" name="_token" value="{{ csrf_token()}}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label text-left">First Name <span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Type your firt name..." required />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label text-left">Last Name <span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Type your last name..." required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row div-margintop">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label text-left">User Name<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Type your user user name..." required />
                                            <input type="hidden" name="old_user_name" id="old_user_name"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label text-left">User Group<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <select id="user_group_id" name="user_group_id" class="form-control" style="width: 100%" required>
                                                <option value="">Select User Group</option>
                                                @foreach ($user_groups as $user)

                                                        <option value="{{$user->id}}">{{$user->name}}</option>

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row div-margintop">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label text-left">Password<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="password" name="password" id="password" class="form-control" placeholder="Type your password..." required />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label text-left">Confirm Password<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="password" name="re_password" id="re_password" class="form-control" placeholder="Re-enter password..." />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row div-margintop">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label text-left">email<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" name="email" id="email" class="form-control" placeholder="Type your email..." required />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label text-left">Contact NO<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" name="contact_no" id="contact_no" class="form-control" placeholder="Type your contact NO..." required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="userFormsubmit()">Save changes</button>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->
@foreach($js_files as $js_file)
<script type="text/javascript" src="{{ $js_file}}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
@endforeach 
<script>
    var dataTable;
    var validator;
    $(document).ready(function () {
        'use strict';
        $('#main_menu_admin').addClass("active");
        $('#sub_menu_manage_users').addClass("active");
        var users =<?php echo $users ?>;

        dataTable = $('#dataTable1').dataTable({
            "aaSorting": [[0, 'desc']],
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
            "pageLength": 25,
            "columnDefs": [{"targets": [0],"visible": false}],
        });
        fillUserDetailsDataTable(users);
    });
    validator = $('#formInput').validate({

        rules: {
            user_name: {
                remote: function ()
                {
                    return {
                        url: base_url + "/user/username_exist_check",
                        type: "get",
                        async : false, 
                        data: {
                            old_user_name: function () {
                                return $("#old_user_name").val();
                            }
                        }

                    };
                }
            },
            password: {
                required: true,
                minlength: 5
            },
            re_password: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            },
            email: {
                email: true
            },
            contact_no: {
                phonenumber: true
            }
        },
        messages: {
            user_name: {
                remote: "This user Name already exist"
            }
        },
        highlight: function (element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        }
    });
    function userFormsubmit() {
        if ($("#formInput").valid()) {
            $.ajax({
                type: 'post',
                url: base_url + '/user',
                cache: false,
                data: $('#formInput').serialize(),
                success: function (json) {
                    var result = jQuery.parseJSON(json);
                    if (result.response) {
                        fillUserDetailsDataTable(result.data);
                        $('#myModal').modal('hide');
                        var text = $('#id').val() != "" ? "Updated" : "Added";
                        $.gritter.add({
                            title: 'Success',
                            text: 'User ' + text + ' Successfully.',
                            class_name: 'with-icon check-circle success'
                        });
                    }
                }
            });
        }
    }

    function getUserData(id) {
        $.ajax({
            type: 'get',
            url: base_url + '/user/' + id + '/edit',
            cache: false,
            success: function (json) {
                var result = jQuery.parseJSON(json);
                if (result.response) {
                      $('#formInput').trigger("reset");
            $('#formInput .form-group').removeClass('has-error');
            $('#formInput .error').remove();
                    $('#formInput').trigger("reset");
                    $('#id').val(result.data.id);
                    $('#first_name').val(result.data.first_name);
                    $('#last_name').val(result.data.last_name);
                    $('#user_name').val(result.data.username);
                    $("#old_user_name").val(result.data.username);
                    $('#user_group_id').val(result.data.user_groub_id);
                    $('#email').val(result.data.email);
                    $('#contact_no').val(result.data.contact_no);
                    $('#myModal').modal('show');
                }
            }
        });
    }
    function deleteUser(id, name) {

        $.confirm({
            theme: 'supervan',
            title: 'Users!',
            content: 'Do you want to delete user : ' + "<strong>" + name + "</strong>",
            icon: 'fa fa-warning',
            columnClass: 'col-md-6 col-md-offset-3',
            typeAnimated: true,
            type: 'red',
            buttons: {
                tryAgain: {
                    text: 'Delete it',
                    btnClass: 'btn-red',
                    action: function () {
                        deleteAjaxCall(id);
                    }
                },
                close: function () {
                }
            }
        });

        function deleteAjaxCall(id) {
            $.ajax({
                type: 'delete',
                url: base_url + '/user/' + id,
                cache: false,
                data: {_token: $('#_token').val()},
                success: function (json) {
                    var result = jQuery.parseJSON(json);
                    if (result.response) {
                        fillUserDetailsDataTable(result.data);
                        $('#myModal').modal('hide');
                        $.gritter.add({
                            title: 'Success',
                            text: 'User Deleted Successfully.',
                            class_name: 'with-icon check-circle success'
                        });
                    }
                }
            });
        }

    }
    function fillUserDetailsDataTable(data) {
        var oSettings = dataTable.fnSettings();
        dataTable.fnClearTable(this);
        $.each(data, function (index, value) {
            dataTable.oApi._fnAddData(oSettings, [value.id,
                value.username,
                value.user_groups.name,
                value.contact_no,
                value.email,
                "<ul class='table-options'><li><a onclick='getUserData(" + value.id + ")' ><i class='fa fa-pencil'></i></a></li><li><a onclick='deleteUser(" + value.id + ",\"" + value.username + "\")'><i class='fa fa-trash'></i></a></li></ul>"
            ]);
        });

        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
        dataTable.fnDraw();
    }
    function reset_form() {
        $('#formInput').trigger("reset");
        $('#formInput .form-group').removeClass('has-error');
        $('#formInput .error').remove();
        $('#id').val("");
        $('#old_user_name').val("");
    }
    function close_btn(){
         window.location.href = base_url + '/home';
    }
</script>
@endsection