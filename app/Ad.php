<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    //
    protected $fillable = ['catid','User_Mail','Header','Name', 'Surname', 'Town', 'Municipality','Region', 'Email', 'Description', 'State'];

    public function categories(){
    	return $this->hasMany('App\Category');
    }
}
