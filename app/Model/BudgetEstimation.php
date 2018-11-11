<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BudgetEstimation extends Model
{
    protected $table='budget_estimation';
    public $timestamps='false';
    protected $fillable=['user_id','last_billing_date', 'next_billing_date', 'budget', 'budget_units', 'home_id'];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function home(){
        return $this->belongsTo(Home::class,'home_id','id');
    }

    public function delete(){
        $this->is_active=2;
        $this->save();
        return true;
    }
}
