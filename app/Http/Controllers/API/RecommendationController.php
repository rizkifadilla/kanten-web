<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RecommendationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function popular($key)
    {
        //
        if($key != $this->privateKey) {
            return [
                'code'    => '200',
                'message' => 'error',
                'reason'  => 'api key was not valid.'
            ];
        } else {
            $data = DB::select('SELECT inventories.*, inventories_stocks.stock FROM inventories, inventories_stocks WHERE inventories.id = inventories_stocks.inventoriesId AND inventories_stocks.stock != 0 ORDER BY RAND()');
            // $data = DB::select('SELECT inventories.*, IFNULL(inventories_stocks.stock,"") as stock FROM inventories, transactions, shop_transactions, inventories_stocks WHERE inventories_stocks.inventoriesId = inventories.id AND shop_transactions.inventoriesId = inventories.id AND shop_transactions.inventoriesId IS NOT NULL AND (SELECT inventories_stocks.stock FROM inventories_stocks WHERE inventories_stocks.inventoriesId = inventories.id != 0) GROUP BY inventories.id, inventories.shopId, inventories.inventoriesType, inventories.image, inventories.name, inventories.price, inventories.created_at, inventories.updated_at, inventories_stocks.stock ORDER BY COUNT(shop_transactions.inventoriesId) DESC LIMIT 10');
            if (count($data) == 0) {
                return [
                    'code'    => '200',
                    'message' => 'no data'
                ];
            } else {
                return [
                    'code'    => '200',
                    'message' => 'success',
                    'results' => $data
                ];
            }
        }
    }

}
