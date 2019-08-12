<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class CartController extends Controller
{
    //
    public function create(Request $req){
        $orderId = str_random(10);
        
        foreach($req->carts as $cartData){
            $cart = new \App\cart;
            $cart->orderId = $orderId;
            $cart->userId = Auth::user()->id;
            $cart->inventoriesId = $cartData['inv_id'];
            $cart->inventoriesQty = $cartData['inv_qty'];
            
            $cart->save();
        }


        return response()->json([
            "message" => "OKE!",
            "status" => 200,
            "orderId" => $orderId
        ]);
    }
}
