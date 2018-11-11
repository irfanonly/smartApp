<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //
    protected $table='rooms';
    public $timestamps='false';
    protected $fillable=['is_active','name','home_id'];

    public function home(){
        return $this->belongsTo(Home::class,'home_id','id');
    }

    public function devices(){
        return $this->hasMany(Device::class,'room_id','id');
    }

    public function delete(){
        $this->is_active=2;
        $this->save();
        foreach ($this->devices as $device){
            $device->delete();
        }
        return true;
    }
}
