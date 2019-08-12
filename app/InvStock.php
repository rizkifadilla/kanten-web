<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvStock extends Model
{
    //
    protected $table = 'inventories_stocks';
    protected $filelable = ['inventoriesId','stock'];
}
