<div class="col-md-12">
    <ol class="breadcrumb breadcrumb-quirk">
        <li class="active"><i class="fa fa-desktop"></i> Homes</li>
    </ol>
</div>

@php
    $is_admin=(session()->get('user_group')==1);
@endphp

<ul class="notes row">
    @foreach($homes as $key=>$home)
        <li class="col-md-3">
            <div class="rotate-1 lazur-bg div-notes">
                <small>{{$home->updated_at}}</small>&nbsp;
                <h4 class="text-center" onclick="homeselect({{$home->id}})"><i style="font-size: 44px;" class="fa fa-home"></i><span
                                              id="home_title_{{$home->id}}">{{$home->name}}</span>
                    <input
                            class="form-control" type="hidden" id="home_{{$home->id}}" name="home_{{$home->id}}"
                            @if($is_admin)onkeyup="homeupdate(event,{{$home->id}})"@endif></h4>
                @if($is_admin)
                <a  onclick="homedelete({{$home->id}})" class="text-danger pull-left"><i class="fa fa-trash-o "></i></a>&nbsp;
                <a onclick="homeedit({{$home->id}})" class="text-danger pull-right"><i class="fa fa-pencil"></i></a>
                @endif
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
                <small>&nbsp;</small>&nbsp;
                <h4 class="text-center"><i class="fa fa-plus-square" style="font-size:20px;" onclick="newhome()"
                                           id="new_home_icon"></i><span id="home_title_new"
                                                                        hidden>Awesome title</span><input
                            class="form-control" type="hidden" id="home_new" name="home_new" onkeyup="homeNew(event)"></h4>
                &nbsp;
            </div>
        </li>
    @endif
</ul>