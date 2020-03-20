<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    //
    protected $fillable = ['regionid','Name'];

    public function Region() {
    	return $this->hasOne('App\Region');
    }
}
