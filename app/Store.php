<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    //
    protected $table = 'shops';
    protected $filelable = ['isOpen','sellerId','image','name','description'];

    public function inventorie()
    {
        return $this->belongsTo('App\Inventorie');
    }

}
