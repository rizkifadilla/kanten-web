<?php

namespace App\Http\Controllers;

use App\cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Alert;
use App\UserAccounts;

class BuyController extends Controller
{
    //

    public function index($orderId)
    {
        $cart = DB::select("SELECT shop_carts.id, shop_carts.userId, (SELECT inventories.name FROM inventories WHERE inventories.id = shop_carts.inventoriesId) AS inventoriesId, shop_carts.inventoriesQty, (SELECT inventories.price * shop_carts.inventoriesQty FROM inventories WHERE shop_carts.inventoriesId = inventories.id) AS balanceUsed FROM shop_carts WHERE shop_carts.orderId = '$orderId'");
        $total = DB::select("SELECT SUM(inventories.price * shop_carts.inventoriesQty) as total from inventories, shop_carts where inventories.id = shop_carts.inventoriesId and shop_carts.orderId = '$orderId' LIMIT 1");
        $dataReceipt = DB::select("SELECT shop_carts.inventoriesQty AS qty, (SELECT inventories.name FROM inventories WHERE inventories.id = shop_carts.inventoriesId) AS makanan, (SELECT inventories.price * shop_carts.inventoriesQty) AS total, (SELECT now()) AS date FROM shop_carts, inventories WHERE shop_carts.inventoriesId = inventories.id and shop_carts.orderId = '$orderId'");
        $ord = $orderId;
        // $cart = cart::where('orderId', $orderId)->first();
        // return $cart->inventorie;
        return view('buy_cart', compact('cart','total','dataReceipt','ord'));
    }
    public function buyCart(Request $request)
    {
        $buy = new \App\Transaction;
        $cardid = $request->get('fromUserId');
        $cek = UserAccounts::where('cardId',$cardid)->first()->balance;
        $buy->sender = UserAccounts::where('cardId',$cardid)->first()->userId;
        $balanceUse = $request->get('price');
        $buy->balanceUsed = $request->get('price');
        $buy->recepient = $request->get('toUserId');
        $buy->type = 2;
        $buy->client = 1;
        if($cek >= $balanceUse){
            $buy->save();
            Alert::success('Transaksi Telah Berhasil Dilakukan', 'Berhasil');
            return redirect('/inventories');
        }else{
            Alert::error('Transaksi Gagal Silahkan Cek Saldo anda', 'Gagal');
            return redirect($request->server('HTTP_REFERER'));
        }
    }
}
