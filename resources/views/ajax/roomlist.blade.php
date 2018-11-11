<div class="col-md-12">
    <ol class="breadcrumb breadcrumb-quirk">
        <li onclick="breadcrumbOnclick()"><i class="fa fa-desktop"></i> Homes</li>
        <li class="active">{{$home->name}}</li>
    </ol>
</div>

@php
    $is_admin=(session()->get('user_group')==1);
@endphp

<ul class="notes row">
    @foreach($rooms as $key=>$room)
        <li class="col-md-3">
            <div class="rotate-1 lazur-bg div-notes">
                <small>{{$room->updated_at}}</small>&nbsp;
                <h4 class="text-center"><span onclick="roomselect({{$room->id}})"
                                              id="room_title_{{$room->id}}">{{$room->name}}</span><input
                            class="form-control" type="hidden" id="room_{{$room->id}}" name="room_{{$room->id}}"
                            @if($is_admin)onkeyup="roomupdate(event,{{$room->id}})"@endif></h4>
                @if($is_admin)
                <a  onclick="roomdelete({{$room->id}})" class="text-danger pull-left"><i class="fa fa-trash-o "></i></a>&nbsp;
                <a onclick="roomedit({{$room->id}})" class="text-danger pull-right"><i class="fa fa-pencil"></i></a>
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
                <h4 class="text-center"><i class="fa fa-plus-square" style="font-size:20px;" onclick="newroom({{$home->id}})"
                                           id="new_room_icon"></i><span id="room_title_new"
                                                                        hidden>Awesome title</span><input
                            class="form-control" type="hidden" id="room_new" name="room_new" onkeyup="roomNew(event,{{$home->id}})"></h4>
                &nbsp;
            </div>
        </li>

    @endif
</ul>