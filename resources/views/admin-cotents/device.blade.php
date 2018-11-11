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
        .select2-container{
           /* z-index:100000;*/
        }
        .select2-container--default .select2-selection--single .select2-selection__choice {

            background-color: #259dab !important;
        }



        /*ul.notes li {*/
            /*margin: 10px 40px 50px 0px;*/
            /*float: left;*/
        /*}*/

        ul.notes li, ul.tag-list li {
            list-style: none;
        }

        ul.notes li div small {
            position: absolute;
            top: 5px;
            right: 5px;
            font-size: 10px;
        }

        div.rotate-1 {
            -webkit-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
        }

        div.rotate-2 {
            -o-transform: rotate(4deg);
            -webkit-transform: rotate(4deg);
            -moz-transform: rotate(4deg);
            position: relative;
            top: 5px;
        }

        .lazur-bg {
            background-color: #23c6c8;
            color: #ffffff;
        }

        .red-bg {
            background-color: #ed5565;
            color: #ffffff;
        }

        .navy-bg {
            background-color: #1ab394;
            color: #ffffff;
        }

        .yellow-bg {
            background-color: #f8ac59;
            color: #ffffff;
        }

        ul.notes li .div-notes{
            text-decoration: none;
            color: #000;
            display: block;
            /*height: 210px;*/
            /*width: 210px;*/
            padding: 1em;
            -moz-box-shadow: 5px 5px 7px #212121;
            -webkit-box-shadow: 5px 5px 7px rgba(33, 33, 33, 0.7);
            box-shadow: 5px 5px 7px rgba(33, 33, 33, 0.7);
            -moz-transition: -moz-transform 0.15s linear;
            -o-transition: -o-transform 0.15s linear;
            -webkit-transition: -webkit-transform 0.15s linear;
        }

.lazur-bg h4 {
    cursor: pointer;
}

    </style>
    <div class="contentpanel" style="overflow-x: hidden;">

        <ol class="breadcrumb breadcrumb-quirk">
            {{--<li><a href="{{URL::to('/device')}}"><i class="fa fa-desktop"></i> DASHBOARD</a></li>--}}
            <li class="active"><i class="fa fa-desktop"></i> Device</li>
        </ol>

        <div class="panel">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <h1 class="panel-title col-md-10"><strong>Devices</strong></h1>
                        <button onclick="close_btn()"  class="pull-right close-btn"><i class="fa fa-times" aria-hidden="true"></i> </button>
                        @if(session()->get('user_group')==1)
                        @endif
                    </div>
                </div>
                <div class="panel-body" >
                    <input type="hidden" id="_token" name="_token" value="{{ csrf_token()}}">
                    @if(session()->get('user_group')==1)

                    <div class="row">
                        <div class="col-d-12">
                            <div class="col-md-4 col-md-offset-3">
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-left">User<span
                                            class="text-danger">*</span></label>
                                <div class="col-sm-9">

                                    <select id="app_user"  name="app_user" class="form-control" style="width: 100%" data-placeholder="Users"  required onchange="appUserChange()">
                                        <option value="">Select User</option>
                                        @foreach($users as $key => $value)
                                            <option value="{{$value->id}}">{{$value->username}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            </div>
                        </div>

                    </div>
                    @endif
                    <div class="table-responsive" style="overflow-x: hidden;">
                        <div class="row" style="margin-top: 50px;">
                            <div class="col-md-12">
                                <div  id="ul_home">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 50px;" id="div_room" hidden>

                            <div class="col-md-12">
                                <div  id="ul_room">

                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 50px;" id="div_device" hidden>

                            <div class="col-md-12">
                                <div  id="ul_device">

                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 50px;" id="div_device_data" hidden>

                            <div class="col-md-12">
                                <div  id="ul_device_data">

                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div><!-- panel -->
    </div><!-- contentpanel -->

    @foreach($js_files as $js_file)
        <script type="text/javascript" src="{{ $js_file}}"></script>

    @endforeach
    <script>
        var dataTable;
        var validator;
        var enter_first=true;
        var bootstrap_change_first=true;
        $(document).ready(function () {
            'use strict';
            $('#main_menu_device').addClass("active");


            $('#is_status').bootstrapSwitch('state', false);
            $('#app_user').select2();
            @if(session()->get('user_group')!=1)
            $.ajax({
                type: 'get',
                url: base_url + '/device/get-homes',
                cache: false,
                data:{id:'{{session()->get('users_id')}}','_token':$('#_token').val()},
                success: function (json) {
                    var result = jQuery.parseJSON(json);
                    $('#ul_home').empty();
                    $('#ul_home').append(result);

                }
            });
            @endif

        });


        function appUserChange() {
            $.ajax({
                type: 'get',
                url: base_url + '/device/get-homes',
                cache: false,
                data:{id:$('#app_user').val(),'_token':$('#_token').val()},
                success: function (json) {
                    var result = jQuery.parseJSON(json);
                    $('#ul_home').empty();
                    $('#ul_home').append(result);

                }
            });
            
        }
        
        function homeedit(id) {
            $('#home_'+id).attr('type', 'text');
            $('#home_'+id).val( $('#home_title_'+id).text());
            $('#home_title_'+id).text('');
            
        }
        function homeupdate(event,id) {
            if (event.keyCode === 13) {
                $('#home_title_'+id).text( $('#home_'+id).val());
                $('#home_'+id).attr('type', 'hidden');
                $.ajax({
                    type: 'post',
                    url: base_url + '/device/add-home',
                    cache: false,
                    data: {name: $('#home_'+id).val(), '_token': $('#_token').val(), user_id: $('#app_user').val(),id:id,is_active:1},
                    success: function (json) {
                        var result = jQuery.parseJSON(json);
                        if (result.response) {
                            $.gritter.add({
                                title: 'Success',
                                text: 'Home Updated Successfully.',
                                class_name: 'with-icon check-circle success'
                            });
                            $('#ul_home').empty();
                            $('#ul_home').append(result.data);
                        }
                        enter_first=true;
                    }
                });
            }
            
        }
        function newhome() {
            $('#new_home_icon').hide();
            $('#home_new').attr('type', 'text');
             enter_first=true;

        }


        function homeNew(event) {
            if (event.keyCode === 13) {
                if(enter_first) {
                    enter_first=false;
                    $.ajax({
                        type: 'post',
                        url: base_url + '/device/add-home',
                        cache: false,
                        data: {name: $('#home_new').val(), '_token': $('#_token').val(), user_id: $('#app_user').val()},
                        success: function (json) {
                            var result = jQuery.parseJSON(json);
                            if (result.response) {
                                $.gritter.add({
                                    title: 'Success',
                                    text: 'Home Created Successfully.',
                                    class_name: 'with-icon check-circle success'
                                });
                                $('#ul_home').empty();
                                $('#ul_home').append(result.data);
                            }
                            enter_first=true;
                        }
                    });
                }

            }
        }

        function homeselect(id) {

            $.ajax({
                type: 'get',
                url: base_url + '/device/get-rooms',
                cache: false,
                data:{id:id,'_token':$('#_token').val()},
                success: function (json) {
                    var result = jQuery.parseJSON(json);
                    $('#ul_home').hide();
                    $('#div_room').show();
                    // $('#breadcrumb_home').text($('#home_title_'+id).text())
                    $('#ul_room').empty();
                    $('#ul_room').append(result);

                }
            });

        }
        function breadcrumbOnclick() {
            @if(session()->get('user_group')!=1)
                    var user_id={{session()->get('user_group')}};
            @else
                    var user_id=$('#app_user').val();
            @endif


            $.ajax({
                type: 'get',
                url: base_url + '/device/get-homes',
                cache: false,
                data:{id:user_id,'_token':$('#_token').val()},
                success: function (json) {
                    var result = jQuery.parseJSON(json);
                    $('#ul_home').show();
                    $('#div_room').hide();
                    $('#div_device').hide()
                    $('#div_device_data').hide();
                    $('#ul_home').empty();
                    $('#ul_home').append(result);

                }
            });
        }
        function homedelete(id) {
            $.confirm({
                theme: 'supervan',
                title: 'Home!',
                content: 'This will delete all related rooms and devices. Do you want to proceed?',
                icon: 'fa fa-warning',
                columnClass: 'col-md-6 col-md-offset-3',
                typeAnimated: true,
                type: 'red',
                buttons: {
                    tryAgain: {
                        text: 'Delete it',
                        btnClass: 'btn-red',
                        action: function () {
                            homeDeleteAjaxCall(id);
                        }
                    },
                    close: function () {
                    }
                }
            });

        }


        function homeDeleteAjaxCall(id) {
            $.ajax({
                type: 'post',
                url: base_url +'/device/add-home',
                cache: false,
                data: {_token: $('#_token').val(),id:id,is_active:2},
                success: function (json) {
                    var result = jQuery.parseJSON(json);
                    if (result.response) {
                        $.gritter.add({
                            title: 'Success',
                            text: 'Home Deleted Successfully.',
                            class_name: 'with-icon check-circle success'
                        });
                        $('#ul_home').empty();
                        $('#ul_home').append(result.data);

                    }
                }
            });
        }
        function roomdelete(id) {
            $.confirm({
                theme: 'supervan',
                title: 'Room!',
                content: 'This will delete all related  devices. Do you want to proceed?',
                icon: 'fa fa-warning',
                columnClass: 'col-md-6 col-md-offset-3',
                typeAnimated: true,
                type: 'red',
                buttons: {
                    tryAgain: {
                        text: 'Delete it',
                        btnClass: 'btn-red',
                        action: function () {
                            roomDeleteAjaxCall(id);
                        }
                    },
                    close: function () {
                    }
                }
            });

        }


        function roomDeleteAjaxCall(id) {
            $.ajax({
                type: 'post',
                url: base_url +'/device/add-room',
                cache: false,
                data: {_token: $('#_token').val(),id:id,is_active:2},
                success: function (json) {
                    var result = jQuery.parseJSON(json);
                    if (result.response) {
                        $.gritter.add({
                            title: 'Success',
                            text: 'Room Deleted Successfully.',
                            class_name: 'with-icon check-circle success'
                        });
                        $('#ul_room').empty();
                        $('#ul_room').append(result.data);

                    }
                }
            });
        }


        function roomedit(id) {
            $('#room_'+id).attr('type', 'text');
            $('#room_'+id).val( $('#room_title_'+id).text());
            $('#room_title_'+id).text('');
        }
        function newroom(){
            $('#new_room_icon').hide();
            $('#room_new').attr('type', 'text');
            enter_first=true;

        }
        function roomNew(event,home_id) {
            if (event.keyCode === 13) {
                if(enter_first) {
                    enter_first=false;
                    $.ajax({
                        type: 'post',
                        url: base_url + '/device/add-room',
                        cache: false,
                        data: {name: $('#room_new').val(), '_token': $('#_token').val(), home_id: home_id},
                        success: function (json) {
                            var result = jQuery.parseJSON(json);
                            if (result.response) {
                                $.gritter.add({
                                    title: 'Success',
                                    text: 'Room Created Successfully.',
                                    class_name: 'with-icon check-circle success'
                                });
                                $('#ul_room').empty();
                                $('#ul_room').append(result.data);
                            }
                            enter_first=true;
                        }
                    });
                }

            }
        }
        function roomupdate(event,id) {
            if (event.keyCode === 13) {
                $('#room_title_'+id).text( $('#room_'+id).val());
                $('#room_'+id).attr('type', 'hidden');
                $.ajax({
                    type: 'post',
                    url: base_url + '/device/add-room',
                    cache: false,
                    data: {name: $('#room_'+id).val(), '_token': $('#_token').val(),id:id,is_active:1},
                    success: function (json) {
                        var result = jQuery.parseJSON(json);
                        if (result.response) {
                            $.gritter.add({
                                title: 'Success',
                                text: 'Room Updated Successfully.',
                                class_name: 'with-icon check-circle success'
                            });
                            $('#ul_room').empty();
                            $('#ul_room').append(result.data);
                        }
                        enter_first=true;
                    }
                });
            }

        }

        function newDevice(id) {
            $('#new_device_icon').hide();
            $('#device_new').attr('type', 'text');
            $('#device_watts').attr('type', 'text');
            $('#new_device_unique').attr('type', 'text');
            $('#limit_value').attr('type', 'text');
            $('#suport_device').attr('type', 'text');
            enter_first=true;

        }

        function roomselect(id) {
            $.ajax({
                type: 'get',
                url: base_url + '/device/get-devices',
                cache: false,
                data:{id:id,'_token':$('#_token').val()},
                success: function (json) {
                    var result = jQuery.parseJSON(json);
                    bootstrap_change_first=false;
                    $('#div_room').hide();
                    $('#div_device').show();
                    // $('#breadcrumb_home').text($('#home_title_'+id).text())
                    $('#ul_device').empty();
                    $('#ul_device').append(result.data);
                    $.each(result.devices, function (index, value) {
                        var status=value.status==1?true:false;
                        $('#is_status_'+value.id).bootstrapSwitch('state', status);
                    });
                    bootstrap_change_first=true;
                    // $('#is_status_1').bootstrapSwitch('state', false);
                    // $('#is_status_2').bootstrapSwitch('state', false);

                }
            });

        }


        function deviceNew(event,room_id) {
            if (event.keyCode === 13) {
                if(enter_first) {
                    enter_first=false;
                    $.ajax({
                        type: 'post',
                        url: base_url + '/device/add-device',
                        cache: false,
                        data: {name: $('#device_new').val(), '_token': $('#_token').val(), room_id: room_id,unique_id:$('#new_device_unique').val(),status:1, watts : $('#device_watts').val(), suport_device: $('#suport_device').val(), limit_value: $('#limit_value').val() },
                        success: function (json) {
                            var result = jQuery.parseJSON(json);
                            if (result.response) {
                                $.gritter.add({
                                    title: 'Success',
                                    text: 'Device Created Successfully.',
                                    class_name: 'with-icon check-circle success'
                                });
                                bootstrap_change_first=false;
                                $('#ul_device').empty();
                                $('#ul_device').append(result.data);
                                $.each(result.devices, function (index, value) {
                                    var status=value.status==1?true:false;
                                    $('#is_status_'+value.id).bootstrapSwitch('state', status);
                                });
                                bootstrap_change_first=true;
                            }else{
                                $.gritter.add({
                                    title: 'Validation Error',
                                    text: result.data,
                                    class_name: 'with-icon check-circle danger'
                                });
                            }
                            enter_first=true;
                        }
                    });
                }

            }
        }
        function deviceupdate(event,id) {
            if (event.keyCode === 13) {
                $('#device_title_'+id).text( $('#device_'+id).val());
                $('#device_title_watt_'+id).text( $('#device_watts_'+id).val());

                $('#device_watts_'+id).attr('type', 'hidden');
                $('#device_'+id).attr('type', 'hidden');
                $('#device_suport_device_'+id).attr('type', 'hidden');
                $('#device_limit_value_'+id).attr('type', 'hidden');
                $.ajax({
                    type: 'post',
                    url: base_url + '/device/add-device',
                    cache: false,
                    data: {name: $('#device_'+id).val(), '_token': $('#_token').val(),id:id,is_active:1,status:$('#is_status_'+id).bootstrapSwitch('state') ? 1 : 0, watts: $('#device_watts_'+id).val(), suport_device: $('#device_suport_device_'+id).val(), limit_value: $('#device_limit_value_'+id).val()},
                    success: function (json) {
                        var result = jQuery.parseJSON(json);
                        if (result.response) {
                            $.gritter.add({
                                title: 'Success',
                                text: 'Device Updated Successfully.',
                                class_name: 'with-icon check-circle success'
                            });
                            $('#ul_device').empty();
                            $('#ul_device').append(result.data);
                            bootstrap_change_first=false;
                            $.each(result.devices, function (index, value) {
                                var status=value.status==1?true:false;
                                $('#is_status_'+value.id).bootstrapSwitch('state', status);
                            });
                            bootstrap_change_first=true;
                        }
                    }
                });
            }

        }

        function statusUpdate(id) {
            if(bootstrap_change_first){
                $.ajax({
                    type: 'post',
                    url: base_url + '/device/add-device',
                    cache: false,
                    data: { '_token': $('#_token').val(),id:id,is_active:1,status:$('#is_status_'+id).bootstrapSwitch('state') ? 1 : 0},
                    success: function (json) {
                        var result = jQuery.parseJSON(json);
                        if (result.response) {
                            $.gritter.add({
                                title: 'Success',
                                text: 'Device Status Updated Successfully.',
                                class_name: 'with-icon check-circle success'
                            });

                        }
                    }
                });
            }


        }
        function deviceedit(id) {
            $('#device_'+id).attr('type', 'text');
            $('#device_watts_'+id).attr('type', 'text');
            $('#device_'+id).val( $('#device_title_'+id).text());
            $('#device_title_'+id).text('');
            $('#device_title_watt_'+id).text('');
            $('#device_limit_value_'+id).attr('type', 'text');
            $('#device_suport_device_'+id).attr('type', 'text');

        }

        function breadcrumbOnclickHome(id) {
            $.ajax({
                type: 'get',
                url: base_url + '/device/get-rooms',
                cache: false,
                data:{id:id,'_token':$('#_token').val()},
                success: function (json) {
                    var result = jQuery.parseJSON(json);
                    $('#ul_home').hide();
                    $('#div_room').show();
                    $('#div_device').hide();
                    $('#div_device_data').hide();
                    // $('#breadcrumb_home').text($('#home_title_'+id).text())
                    $('#ul_room').empty();
                    $('#ul_room').append(result);

                }
            });

        }

        function deviceselect(id) {

            var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $.ajax({
                type: 'get',
                url: base_url + '/device/get-device-data',
                cache: false,
                data:{id:id,'_token':$('#_token').val(),type:"minutes"},
                success: function (json) {
                    //alert(json);
                    var result = jQuery.parseJSON(json);
                    $('#ul_home').hide();
                    $('#div_room').hide();
                    $('#div_device').hide()
                    $('#div_device_data').show()
                    // $('#breadcrumb_home').text($('#home_title_'+id).text())
                    $('#ul_device_data').empty();
                    $('#ul_device_data').append(result.data);
                    //alert(result.graph_data);
                                       var data = jQuery.parseJSON(result.graph_data),data_amount = jQuery.parseJSON(result.graph_data_amount),
    config = {
      data: data,
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['Total Usage(ms)', 'Total Wastage(ms)'],
      fillOpacity: 0.6,
      hideHover: 'auto',
      behaveLikeLine: true,
      resize: true,
      pointFillColors:['#ffffff'],
      xLabelFormat: function(x){ return months[(new Date(x)).getMonth()]},
      pointStrokeColors: ['black'],
      lineColors:['gray','red']
  },
  config_amount = {
      data: data_amount,
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['Total Usage(Rs.)', 'Total Wastage(Rs.)'],
      fillOpacity: 0.6,
      hideHover: 'auto',
      behaveLikeLine: true,
      resize: true,
      pointFillColors:['#ffffff'],
      xLabelFormat: function(x){ return months[(new Date(x)).getMonth()]},
      pointStrokeColors: ['black'],
      lineColors:['gray','red']
  };
config.element = 'graph-display';
config_amount.element = 'graph-display-amount';
Morris.Area(config);
Morris.Area(config_amount);

                }
            });

        }

        function devicedelete(id) {
            $.confirm({
                theme: 'supervan',
                title: 'Device!',
                content: 'This will delete this device permanently. Do you want to proceed?',
                icon: 'fa fa-warning',
                columnClass: 'col-md-6 col-md-offset-3',
                typeAnimated: true,
                type: 'red',
                buttons: {
                    tryAgain: {
                        text: 'Delete it',
                        btnClass: 'btn-red',
                        action: function () {
                            deviceDeleteAjaxCall(id);
                        }
                    },
                    close: function () {
                    }
                }
            });

        }


        function deviceDeleteAjaxCall(id) {
            $.ajax({
                type: 'post',
                url: base_url +'/device/add-device',
                cache: false,
                data: {_token: $('#_token').val(),id:id,is_active:2,status:$('#is_status_'+id).bootstrapSwitch('state') ? 1 : 0},
                success: function (json) {
                    var result = jQuery.parseJSON(json);
                    if (result.response) {
                        $.gritter.add({
                            title: 'Success',
                            text: 'Device Deleted Successfully.',
                            class_name: 'with-icon check-circle success'
                        });
                        $('#ul_device').empty();
                        $('#ul_device').append(result.data);
                        bootstrap_change_first=false;
                        $.each(result.devices, function (index, value) {
                            var status=value.status==1?true:false;
                            $('#is_status_'+value.id).bootstrapSwitch('state', status);
                        });
                        bootstrap_change_first=true;

                    }
                }
            });
        }
        function breadcrumbOnclickRoom(id) {
            $.ajax({
                type: 'get',
                url: base_url + '/device/get-devices',
                cache: false,
                data:{id:id,'_token':$('#_token').val()},
                success: function (json) {
                    var result = jQuery.parseJSON(json);
                    $('#ul_home').hide();
                    $('#div_room').hide();
                    $('#div_device').show();
                    $('#div_device_data').hide();
                    // $('#breadcrumb_home').text($('#home_title_'+id).text())
                    $('#ul_device').empty();
                    $('#ul_device').append(result.data);

                    bootstrap_change_first=false;
                    $.each(result.devices, function (index, value) {
                        var status=value.status==1?true:false;
                        $('#is_status_'+value.id).bootstrapSwitch('state', status);
                    });
                    bootstrap_change_first=true;

                }
            });

        }

        function filterchange(id) {
            $.ajax({
                type: 'get',
                url: base_url + '/device/get-device-data',
                cache: false,
                data:{id:id,'_token':$('#_token').val(),type:$('#select_device').val()},
                success: function (json) {
                    var result = jQuery.parseJSON(json);
                    $('#ul_home').hide();
                    $('#div_room').hide();
                    $('#div_device').hide()
                    $('#div_device_data').show()
                    // $('#breadcrumb_home').text($('#home_title_'+id).text())
                    $('#ul_device_data').empty();
                    $('#ul_device_data').append(result.data);
                    Morris.Bar({
                        element: 'graph-display',
                        data: result.graph_data,
                        xkey: 'name',
                        ykeys: ['wattph'],
                        labels: ['Watts Per Hour'],
                        gridTextSize:10,
                        goals: [result.average],
                        goalLineColors:['red'],
                        hideHover:false,
                    });


                }
            });

        }



        function close_btn(){
            window.location.href = base_url + '/main';
        }
    </script>
@endsection