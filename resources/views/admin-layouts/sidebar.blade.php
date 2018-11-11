<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="leftpanel">
    <div class="leftpanelinner">

        <!-- ################## LEFT PANEL PROFILE ################## -->

        <div class="media leftpanel-profile">
            <div class="media-left">
                <a href="#">
                    <img id="sidebar_user_image" src="{{ asset('public/images/users/'.$user_data->user_image)}}" alt=""
                         class="media-object img-circle">
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading"><span
                            id="sidebar_name">{{ $user_data->first_name." ".$user_data->last_name }}</span> <a
                            data-toggle="collapse" data-target="#loguserinfo" class="pull-right"><i
                                class="fa fa-angle-down"></i></a></h4>
                <span id="sidebar_position">{{session()->get('position') }}</span>
            </div>
        </div><!-- leftpanel-profile -->

        <div class="leftpanel-userinfo collapse" id="loguserinfo">
            <h5 class="sidebar-title">Contact</h5>
            <ul class="list-group">
                <li class="list-group-item">
                    <label class="pull-left">Email</label>
                    <span class="pull-right" id="sidebar_email">{{$user_data->email }}</span>
                </li>
                <li class="list-group-item">
                    <label class="pull-left">Mobile</label>
                    <span class="pull-right" id="sidebar_contact_no">{{$user_data->contact_no }}</span>
                </li>
            </ul>
        </div><!-- leftpanel-userinfo -->

        <div class="tab-content">

            <!-- ################# MAIN MENU ################### -->

            <div class="tab-pane active" id="mainmenu">
                <h5 class="sidebar-title">Main Menu</h5>
                <!--                <ul class="nav nav-pills nav-stacked nav-quirk">
                              
                                </ul>-->
                <!--               <h5 class="sidebar-title">Main Menu</h5>-->
                <ul class="nav nav-pills nav-stacked nav-quirk">
                    @foreach ($main_menus as $main_menu)
                        @if($main_menu->menu_url)
                            <li id="{{ $main_menu->menu_id }}">
                                <a href="{{ asset($main_menu->menu_url) }}"><i class="{{ $main_menu->menu_icon }}"></i>
                                    <span class="xn-text">{{ $main_menu->menu_name }}</span></a>
                            </li>
                        @else
                            <li id="{{ $main_menu->menu_id }}" class="nav-parent">
                                <a href="#"><i class="{{ $main_menu->menu_icon }}"></i> <span
                                            class="xn-text">{{ $main_menu->menu_name }}</span></a>
                                <ul class="children">
                                    @foreach ($sub_menus as $sub_menu)
                                        @if($main_menu->id == $sub_menu->menu_category)
                                            <li id="{{ $sub_menu->menu_id }}"><a
                                                        href="{{ asset($sub_menu->menu_url) }}"><span
                                                            class="xn-text">{{ $sub_menu->menu_name }}</span></a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach

                </ul>
            </div><!-- tab-pane -->


        </div><!-- tab-content -->

    </div><!-- leftpanelinner -->
</div><!-- leftpanel -->

