<?php

namespace App\Http\Controllers;
use Auth;
use App\Inventorie;
use App\User;
use Alert;
use App\Charts\Kanten;
use App\Charts\Canten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Transaction;
use App\UserAccounts;


class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $id = Auth::user()->id;
        $inventories= DB::select("SELECT inventories.* FROM inventories,shops WHERE inventories.shopId = shops.id AND shops.sellerId = $id");
        $stock = DB::select("SELECT * FROM `inventories_stocks`");
        $notification = DB::select("SELECT * FROM transactions,users WHERE transactions.recepient = $id AND transactions.client = 2 AND users.id = transactions.recepient");
        return view('home',compact('inventories','stock','notification'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $seller = \App\Store::where('sellerId', '=', Auth::user()->id)->first();
        return view('create_item',['seller'=>$seller]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $seller = new \App\Inventorie;
        
        $stock = $request->get('stock');
        if($stock == null){
            $seller->name = $request->get('name');
            $seller->price = $request->get('price');
            $seller->inventoriesType = 2;
            $seller->shopId = $request->get('belongToShop');

            if($request->file('image') == "")
            {
                $seller->image = $seller->image;
            }
            else
            {
                $file = $request->file('image');
                $fileName = $file->getClientOriginalName();
                $request->file('image')->move("image/item", $fileName);
                $seller->image = $fileName;
            }
            $seller->save();
            return redirect('/inventories');
        }else{
            $seller->name = $request->get('name');
            $seller->price = $request->get('price');
            $seller->inventoriesType = 1;
            $seller->shopId = $request->get('belongToShop');

            if($request->file('image') == "")
            {
                $seller->image = $seller->image;
            }
            else
            {
                $file = $request->file('image');
                $fileName = $file->getClientOriginalName();
                $request->file('image')->move("image/item", $fileName);
                $seller->image = $fileName;
            }
            $seller->save();
            $inventoriesId = $seller->id;
            DB::table('inventories_stocks')->insert(
                [
                    'inventoriesId' => $inventoriesId,
                    'stock' => $stock
                ]
            );
            return redirect('/inventories');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $seller = \App\Inventorie::find($id);
        $orderId = Auth::user()->id;
        $dataReceipt = DB::select("SELECT shop_carts.inventoriesQty AS qty, (SELECT inventories.name FROM inventories WHERE inventories.id = shop_carts.inventoriesId) AS makanan, (SELECT inventories.price * shop_carts.inventoriesQty) AS total, (SELECT now()) AS date FROM shop_carts, inventories WHERE shop_carts.inventoriesId = inventories.id and shop_carts.orderId = '$orderId'");
        return view('buy_item',compact('seller','id','dataReceipt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $seller = \App\Inventorie::find($id);
        return view('edit_item',compact('seller','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $seller= \App\Inventorie::find($id);
        $seller->name = $request->get('name');
        $seller->price = $request->get('price');
        $stock = $request->get('stock');
        DB::table('inventories_stocks')->where('inventoriesId',$id)->update(
            [
                'stock' => $stock
            ]
        );
        
        $seller->save();
        return redirect('/inventories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $seller = \App\Inventorie::find($id);
        $seller->delete();
        return redirect('/inventories');
    }
    public function buy(Request $request)
    {
        $buy = new \App\Transaction;
        $jumlah = (int)$request->get('invQty');
        $harga = (int)$request->get('price');
        $cardid = $request->get('fromUserId');
        $balanceUse = $harga*$jumlah;
        $cek = UserAccounts::where('cardId',$cardid)->first()->balance;
        $buy->sender = UserAccounts::where('cardId',$cardid)->first()->userId;
        $buy->balanceUsed = $balanceUse;
        $buy->recepient = $request->get('toUserId');
        $buy->type = 2;
        $buy->client = 1;
        if($cek >= $balanceUse){
            $buy->save();
            $buyQty = new \App\ShopTransaction;
            $buyQty->inventoriesQty = $request->get('invQty');
            $buyQty->inventoriesId = $request->get('invId');
            $buyQty->transactionId = $buy->id;
            $buyQty->save();
            Alert::success('Transaksi Telah Berhasil Dilakukan', 'Berhasil');
            return redirect('/inventories');
        }else{
            Alert::error('Transaksi Gagal Silahkan Cek Saldo anda', 'Gagal');
            return redirect($request->server('HTTP_REFERER'));
        }
    }

    public function chart(){

        $userid = Auth::user()->id;
        $tanggal = date('Y-m-d');
        $data = new Canten;
        $data->labels(['Januari', 'Februari', 'Maret','April', 'Mei', 'Juni','Juli', 'Agustus', 'September','Oktober', 'November', 'Desember']);
        $data->dataset('Pendapatan', 'line', [3000000,2000000,4000000,3500000]);
        $now = DB::select("SELECT * FROM transactions WHERE transactions.created_at LIKE '%$tanggal%'");
        return view('grafikpendapatan', ['data' => $data,'now' => $now]);

    }
    public function search(Request $request){
        $search = $request->search;

        $inventories=DB::select("SELECT * FROM inventories WHERE inventories.name LIKE '%$search%'");;
        return view('home',compact('inventories'));
    }
}
