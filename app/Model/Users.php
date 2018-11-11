<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = true;
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'username', 
        'password', 
        'first_name', 
        'last_name', 
        'user_groub_id', 
        'email',
        'contact_no', 
        'user_image'
    ];
    
    public function UserGroups(){
        return $this->belongsTo('App\Model\UserGroups', 'user_groub_id', 'id');
    }
}