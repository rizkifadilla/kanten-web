<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventorie extends Model
{
    //
    protected $table = 'inventories';
    protected $filelable = ['image','belongToShop','name','price','stock'];

    public function shop()
    {
        return $this->hasMany('App\Store', 'belongToShop');
    }


}
