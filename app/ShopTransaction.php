<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopTransaction extends Model
{
    //
    protected $table = 'shop_transactions';
    protected $fillable = ['transactionId','inventoriesId','inventoriesQty'];
}
