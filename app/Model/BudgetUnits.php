<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BudgetUnits extends Model
{
    //
    protected $table='budget_units';
    public $timestamps='false';
    protected $fillable=['device_id','estimate_unit','avg_usage_day'.'budget_est_id'];

}
