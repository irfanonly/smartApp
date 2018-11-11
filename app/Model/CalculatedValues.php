<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CalculatedValues extends Model
{
    //
    protected $table='calculatedvalues';
    public $timestamps='false';
    protected $fillable=['no_of_app','appliance_id','avg_usage','app_units_month'];

    public function appliances(){
        return $this->belongsTo(Appliances::class,'appliance_id','id');
    }
}
