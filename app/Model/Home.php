<?php

namespace App\Model;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    //
    protected $table='homes';
    public $timestamps='false';
    protected $fillable=['is_active','name','user_id'];

    public function user(){
        return $this->belongsTo(User::class,'room_id','id');
    }

    public function rooms(){
        return $this->hasMany(Room::class,'home_id','id');
    }

    public function delete(){
        $this->is_active=2;
        $this->save();
        foreach ($this->rooms as $room){
            $room->delete();
        }
        return true;
    }
}
