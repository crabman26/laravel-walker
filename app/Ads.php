<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    //
    protected $fillable = ['Name', 'Surname', 'Town', 'Region', 'Email', 'Description', 'State'];
}
