<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DeviceConsumption extends Model
{
    protected $table='device_consumptions';
    public $timestamps='false';
    protected $fillable=['is_active','start_time', 'end_time', 'ampere', 'voltage', 'wattph', 'device_id'];

    public function user(){
        return $this->belongsTo(User::class,'room_id','id');
    }

    public function rooms(){
        return $this->hasMany(Room::class,'home_id','id');
    }

    public function delete(){
        $this->is_active=2;
        $this->save();
        return true;
    }
}
