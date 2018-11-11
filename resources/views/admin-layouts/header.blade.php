<style>
    /* USER PROFILE PAGE */
    .card {
        margin-top: 20px;
        padding: 30px;
        background-color: rgba(214, 224, 226, 0.2);
        -webkit-border-top-left-radius:5px;
        -moz-border-top-left-radius:5px;
        border-top-left-radius:5px;
        -webkit-border-top-right-radius:5px;
        -moz-border-top-right-radius:5px;
        border-top-right-radius:5px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .card.hovercard {
        position: relative;
        padding-top: 0;
        overflow: hidden;
        text-align: center;
        background-color: #fff;
        background-color: rgba(255, 255, 255, 1);
    }
    .card.hovercard .card-background {
        height: 130px;
    }
    .card-background img {
        -webkit-filter: blur(25px);
        -moz-filter: blur(25px);
        -o-filter: blur(25px);
        -ms-filter: blur(25px);
        filter: blur(25px);
        margin-left: -100px;
        margin-top: -200px;
        min-width: 130%;
    }
    .card.hovercard .useravatar {
        position: absolute;
        top: 15px;
        left: 0;
        right: 0;
    }
    .card.hovercard .useravatar img {
        width: 100px;
        height: 100px;
        max-width: 100px;
        max-height: 100px;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        border-radius: 50%;
        border: 5px solid rgba(255, 255, 255, 0.5);
    }
    .card.hovercard .card-info {
        position: absolute;
        bottom: 14px;
        left: 0;
        right: 0;
    }
    .card.hovercard .card-info .card-title {
        padding:0 5px;
        font-size: 20px;
        line-height: 1;
        color: #262626;
        background-color: rgba(255, 255, 255, 0.1);
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }
    .card.hovercard .card-info {
        overflow: hidden;
        font-size: 12px;
        line-height: 20px;
        color: #737373;
        text-overflow: ellipsis;
    }
    .card.hovercard .bottom {
        padding: 0 20px;
        margin-bottom: 17px;
    }
    .btn-pref .btn {
        -webkit-border-radius:0 !important;
    }

</style>
<header>
    <div class="headerpanel">

        <div class="logopanel">
            <h2><a href="index.html">SmartApp</a></h2>
        </div><!-- logopanel -->

        <div class="headerbar">

            <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>

            {{--<div class="searchpanel">--}}
                {{--<div class="input-group">--}}
                    {{--<input type="text" class="form-control" placeholder="Search for...">--}}
                    {{--<span class="input-group-btn">--}}
                        {{--<button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>--}}
                    {{--</span>--}}
                {{--</div><!-- input-group -->--}}
            {{--</div>--}}

            <div class="header-right">
                <ul class="headermenu">

                    <li>
                        <div class="btn-group">
                            <button type="button" class="btn btn-logged" data-toggle="dropdown">
                                <img  id="header_user_image" src="{{ asset('public/images/users/'.$user_data->user_image)}}" alt="" />
                                <span id="header_name">{{ $user_data->first_name." ".$user_data->last_name}}</span>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right">
                                <li><a onclick="getUserProfileData(<?php echo session()->get('users_id'); ?>)"data-toggle="modal" data-target="#userModal"><i class="glyphicon glyphicon-user"></i> My Profile</a></li>

                                <li><a href="{{URL::to('login/logout')}}"><i class="glyphicon glyphicon-log-out"></i> Log Out</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div><!-- header-right -->
        </div><!-- headerbar -->
    </div><!-- header-->
</header>
<div class="modal bounceIn animated" id="userModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Profile Settings</h4>
            </div>
            <div class="modal-body">

                <input type="hidden" class="_token" name="_token" value="{{ csrf_token()}}">
                <input type="hidden" name="user_id"  id="user_id" value="{{ session()->get('users_id') }}">
                <input type="hidden" name="user_image_name"  id="user_image_name">
                <div class="card hovercard">
                    <div class="card-background">
                        <img class="card-bkimg" alt="" id="coverImage"  src="">
                        <!-- http://lorempixel.com/850/280/people/9/ -->
                    </div>
                    <div class="useravatar">
                        <img alt="" id="OpenImgUpload" n src="">
                        <input type="file" id="imgupload" name="imgupload" style="display:none"/> 
                    </div>
                    <div class="card-info"> <span class="card-title">{{ session()->get('username') }}</span>

                    </div>
                </div>
                <div>
                    <ul class="nav nav-tabs nav-primary">
                        <li class="active" style="width: 50%"><a href="#popular5" data-toggle="tab"><strong>Basic Details</strong></a></li>
                        <li style="width: 50%"><a href="#recent5" data-toggle="tab"><strong>Change Password</strong></a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content mb20">
                        <div class="tab-pane active" id="popular5">
                            <form id="userFormInput" autocomplete="off">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label text-left">First Name <span class="text-danger">*</span></label>
                                            <div>
                                                <input type="text" name="user_first_name" id="user_first_name" class="form-control" placeholder="Type your firt name..." required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class=" control-label text-left">Last Name <span class="text-danger">*</span></label>
                                            <div >
                                                <input type="text" name="user_last_name" id="user_last_name" class="form-control" placeholder="Type your last name..." required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label text-left">Email<span class="text-danger">*</span></label>
                                            <div>
                                                <input type="text" name="user_email" id="user_email" class="form-control" placeholder="Type your firt name..." required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class=" control-label text-left">Contact NO <span class="text-danger">*</span></label>
                                            <div >
                                                <input type="text" name="user_contact_no" id="user_contact_no" class="form-control" placeholder="Type your last name..." required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary col-md-12" onclick="userProfileUpdate()">Save changes</button>
                                </div>
                            </form>

                        </div>
                        <div class="tab-pane" id="recent5">
                            <form id="userFormPasswordChange" autocomplete="off">
                                <div class="row">
                                    <div class="form-group">
                                        <label class=" control-label text-left">Old Password <span class="text-danger">*</span></label>
                                        <div >
                                            <input type="password" name="old_password" id="old_password" class="form-control" placeholder="Type Old Password..." required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label class=" control-label text-left">New Password <span class="text-danger">*</span></label>
                                        <div >
                                            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Type New Password..." required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label class=" control-label text-left">Confirm Password <span class="text-danger">*</span></label>
                                        <div >
                                            <input type="password" name="confim_password" id="confim_password" class="form-control" placeholder="Type Confim Password..." required />
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary col-md-12" onclick="passwordChange()">Change Password</button>
                                </div>
                            </form>
                        </div>

                    </div>


                </div>

            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->
</div>

<script>

</script>
