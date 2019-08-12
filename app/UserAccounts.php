<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAccounts extends Model
{
    //
    protected $table = 'user_accounts';
    protected $fillable = ['userId','cardId','balance'];
}
