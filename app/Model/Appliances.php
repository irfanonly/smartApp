<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Appliances extends Model
{
    //
    protected $table='appliances';
    public $timestamps='false';
    protected $fillable=['appload','name'];

}
