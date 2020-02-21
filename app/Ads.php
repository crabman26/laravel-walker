<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    //
    protected $fillable = ['catid','Name', 'Surname', 'Town', 'Municipality','Region', 'Email', 'Description', 'State'];
}
