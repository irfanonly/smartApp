<div class="col-md-12">
    <ol class="breadcrumb breadcrumb-quirk">
        <li onclick="breadcrumbOnclick()"><i class="fa fa-desktop"></i> Homes</li>
        <li onclick="breadcrumbOnclickHome({{$device->room->home->id}})">{{$device->room->home->name}}</li>
        <li onclick="breadcrumbOnclickRoom({{$device->room->id}})">{{$device->room->name}}</li>
        <li class="active">{{$device->name}}</li>
    </ol>
</div>
{{--<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <!--<label class="col-sm-4 control-label text-left" for="select_device">Filter By : </label>
        <select onchange="filterchange({{$device->id}})" class="form-control" id="select_device">
        @foreach($timeArray as $key=>$time)
            <option value="{{$key}}" {{ $key==$type ? "selected" : ""}}>{{$time}}</option>
        @endforeach
        </select>-->
    </div>
</div>--}}
<div class="row">
    {{--<div class="col-md-1"></div>--}}
    <div class="col-md-6">
        <div class="col-sm-12 text-center">
                                <label style="font-size: 20px;" class="label label-success">Month Usage vs Wastage time(ms)</label>
                            </div>
    <div class="col-md-12">
        
        <div id="graph-display">
        </div>
        {{--<div class="col-md-1"></div>--}}
    </div>
    </div>

    <div class="col-md-6">
        <div class="col-sm-12 text-center">
                                <label style="font-size: 20px;" class="label label-success">Month Usage vs Wastage Amount(Rs.)</label>
                            </div>
    <div class="col-md-12">
        
        <div id="graph-display-amount">
        </div>
        {{--<div class="col-md-1"></div>--}}
    </div>
    </div>
    


</div>
