<div class="col-md-12">
    <ol class="breadcrumb breadcrumb-quirk">
        <li onclick="breadcrumbOnclick()"><i class="fa fa-desktop"></i> Homes</li>
        <li onclick="breadcrumbOnclickHome({{$room->home->id}})">{{$room->home->name}}</li>
        <li class="active">{{$room->name}}</li>
    </ol>
</div>

@php
$is_admin=(session()->get('user_group')==1);
@endphp

<ul class="notes row">
    @foreach($devices as $key=>$device)
    <li class="col-md-3">
        <div class="rotate-1 lazur-bg div-notes">
            <span>{{$device->unique_id}}</span>
            <small>{{$device->updated_at}}</small>&nbsp;
            <h4 class="text-center">
                <span onclick="deviceselect({{$device->id}})"
                    id="device_title_{{$device->id}}">{{$device->name}}
              </span>

              <span onclick="deviceselect({{$device->id}})" id="device_title_watt_{{$device->id}}">({{$device->watts}} watts)</span>
              <input
              class="form-control" type="hidden" placeholder="Device Name" id="device_{{$device->id}}" name="device_{{$device->id}}"
              @if($is_admin)onkeyup="deviceupdate(event,{{$device->id}})"@endif>

              <input
              class="form-control" type="hidden" placeholder="Device Watts" id="device_watts_{{$device->id}}" value="{{$device->watts}}" name="device_{{$device->id}}"
              @if($is_admin)onkeyup="deviceupdate(event,{{$device->id}})"@endif>
              <input
              class="form-control" type="hidden" placeholder="Limit value" id="device_limit_value_{{$device->id}}" value="{{$device->limit_value}}" name="device_{{$device->id}}"
              @if($is_admin)onkeyup="deviceupdate(event,{{$device->id}})"@endif>
              <input
              class="form-control" type="hidden" placeholder="Support device" id="device_suport_device_{{$device->id}}" value="{{$device->suport_device}}" name="device_{{$device->id}}"
              @if($is_admin)onkeyup="deviceupdate(event,{{$device->id}})"@endif>

          </h4>
          <div class="row" style="margin-top: 20px;">
            <div class="col-md-4">
                @if($is_admin)
                <a onclick="devicedelete({{$device->id}})" class="text-danger pull-left"><i class="fa fa-trash-o "></i></a>&nbsp;
                @endif
            </div>
            <div class="col-md-4">
                <input type="checkbox" name="is_status_{{$device->id}}" id="is_status_{{$device->id}}"
                class="form-control switch pull-left" data-on-text="On"
                data-off-text="Off" checked onchange="statusUpdate({{$device->id}})">
            </div>
            <div class="col-md-4">
                @if($is_admin)
                <a onclick="deviceedit({{$device->id}})" class="text-danger pull-right"><i class="fa fa-pencil"></i></a>
                @endif
            </div>
        </div>


    </div>
</li>
@if(($key+1) % 4 == 0)
</ul>
<ul class="notes row">
    @endif
    @endforeach

    @if($is_admin)
    <li class="col-md-3">
        <div class="rotate-1 lazur-bg div-notes">
            <span><input type="hidden" id="new_device_unique" name="new_device_unique" onkeyup="deviceNew(event,{{$room->id}})" placeholder="Device unique id" hidden="hidden"> </span>
            <small>&nbsp;</small>&nbsp;
            <h4 class="text-center">
                <i class="fa fa-plus-square" style="font-size:50px;" onclick="newDevice({{$room->id}})"
                 id="new_device_icon"></i>
                 <span id="device_title_new"
                 hidden>Awesome title</span>
                 <input
                 class="form-control" type="hidden" id="device_new" name="device_new" onkeyup="deviceNew(event,{{$room->id}})" placeholder="Device Name">
                 <input
                 class="form-control" type="hidden" id="device_watts" name="device_watts" onkeyup="deviceNew(event,{{$room->id}})" placeholder="Device Watts">
                 <input
                 class="form-control" type="hidden" id="suport_device" name="suport_device" onkeyup="deviceNew(event,{{$room->id}})" placeholder="Support device">
                 <input
                 class="form-control" type="hidden" id="limit_value" name="limit_value" onkeyup="deviceNew(event,{{$room->id}})" placeholder="Limit value">

             </h4>
             &nbsp;
         </div>
     </li>
     @endif
 </ul>