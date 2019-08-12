<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Alert;
use App\UserAccounts;

class AdminController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function topUp(Request $request)
    {
        //
        $id = $request->get('cardId');
        $getPrevBal = UserAccounts::select('balance')->where('cardId', $id)->first();
        $prevBal = $getPrevBal->balance;
        $user = DB::table('user_accounts')->where('cardId', '=', $id)->update(['balance'=>$prevBal + $request->get('balance')]);
        Alert::success('TopUp telah berhasil dilakukan', 'Berhasil');
        return redirect('inventories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeUser($id)
    {
        //
    }
    public function create_card(Request $request)
    {
        $id = $request->get('recognizer');
        $user = User::select('id')->where('recognizer', $id)->first();
        $userId = $user->id;
        DB::table('user_accounts')->where('userId', '=', $userId)->update(['cardId'=>$request->get('cardId')]);
        Alert::success('kartu telah berhasil ditambah', 'Berhasil');
        return redirect('home');
    }
    public function create_store(Request $request)
    {
        $store = new \App\Store;
        $store->sellerId = $request->get('ownerId');
        $store->name = $request->get('shopName');
        $store->description = $request->get('shopDescription');
        $store->isOpen = 0;

        if($request->file('image') == "")
        {
            $store->image = $store->image;
        }
        else
        {
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $request->file('image')->move("image/", $fileName);
            $store->image = $fileName;
        }
        $store->save();
        Alert::success('warung telah berhasil dibuat', 'Berhasil');
        return redirect('home');
    }
}
