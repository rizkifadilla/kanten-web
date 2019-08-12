<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kanten extends Model
{
    //
    protected $table = 'transactions';
    protected $filelable = ['toUserId','fromUserId','transactionType','invId','invQty','balanceUsed','status'];
}
