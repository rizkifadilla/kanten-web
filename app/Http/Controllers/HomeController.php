<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role = DB::select("SELECT user_roles.userType FROM users,user_roles WHERE user_roles.userId=", Auth::user()->id);
        $inventories=DB::select('SELECT inventories.* FROM inventories,shops WHERE inventories.belongToShop = shops.id && shops.sellerId = ', Auth::user()->id);
        $notif = DB::select("SELECT * FROM transactions WHERE transactions.recepient = 1 AND transactions.client = 2");
        return view('home',compact('notif'));
    }
}
