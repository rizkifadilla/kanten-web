<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userRoles extends Model
{
    //
    protected $table = 'user_roles';
    protected $fillable = ['userId','userType'];
}
