<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserGroups extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'user_group';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name'
    ];

}
