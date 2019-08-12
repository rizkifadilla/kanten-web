<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    //
    protected $table = 'shop_carts';
    protected $filelable = ['orderId','userId','inventoriesId','inventoriesQty'];

    // public function inventorie()
    // {
    //     return $this->belongsTo('App\Inventorie', 'invId');
    // }
}
