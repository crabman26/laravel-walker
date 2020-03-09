<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    //
    protected $fillable = ['catid','Header','Name', 'Surname', 'Town', 'Municipality','Region', 'Email', 'Description', 'State'];
}
