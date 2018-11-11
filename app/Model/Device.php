<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    //
    protected $table='devices';
    public $timestamps='false';
    protected $fillable=['is_active','name','unique_id','status','room_id','limit_value','suport_device'];

    public function room(){
        return $this->belongsTo(Room::class,'room_id','id');
    }

    public function consumptions(){
        return $this->hasMany(DeviceConsumption::class,'device_id','id');
    }

    public function delete(){
        $this->is_active=2;
        $this->save();
        foreach ($this->consumptions as $consumption){
            $consumption->delete();
        }
        return true;
    }
}
