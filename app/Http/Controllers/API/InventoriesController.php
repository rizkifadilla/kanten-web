<?php

namespace App\Http\Controllers\Api;

use App\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class InventoriesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all($key)
    {
        //
        if($key != $this->publicKey) {
            return [
                'code'    => '200',
                'message' => 'error',
                'reason'  => 'api key was not valid.'
            ];
        } else {
            $data = DB::select('SELECT inventories.*, IFNULL(inventories_stocks.stock,"") as stock FROM inventories LEFT JOIN inventories_stocks ON inventories_stocks.inventoriesId = inventories.id');
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

    public function byShop($key, $id)
    {
        //
        if($key != $this->publicKey) {
            return [
                'code'    => '200',
                'message' => 'error',
                'reason'  => 'api key was not valid.'
            ];
        } else {
            $data = DB::select('SELECT inventories.*, IFNULL(inventories_stocks.stock,"") as stock FROM inventories LEFT JOIN inventories_stocks ON inventories_stocks.inventoriesId = inventories.id WHERE inventories.shopId='.$id.' ORDER BY stock DESC');
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $key, $sellerId)
    {
        //
        if($key != $this->privateKey) {
            return [
                'code'    => '200',
                'message' => 'error',
                'reason'  => 'api key was not valid.'
            ];
        } else {
            $shopId = $request->post('shopId');
            $invType = $request->post('invType');
            $image = $request->post('image');
            $name = $request->post('name');      
            $price = $request->post('price');       
            $date = date("Y-m-d H:i:s");
            if ($sellerId != $shopId) {
                return [
                    'code'    => '500',
                    'message' => 'internal server error'
                ];
            } else {
                $validator = isset($shopId, $invType, $image, $name, $price, $date);
                if ($validator) {
                    DB::table('inventories')->insert(
                        [
                            'shopId' => $shopId, 
                            'inventoriesType' => $invType,
                            'image' => $image,
                            'name' => $name,
                            'price' => $price,
                            'created_at' => $date,
                            'updated_at' => $date
                        ]
                    );
                    return [
                        'code'    => '200',
                        'message' => 'success'
                    ];
                } else {
                    return [
                        'code'    => '500',
                        'message' => 'data incomplete',
                    ];
                }
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show($key, $id)
    {
        //
        if($key != $this->publicKey) {
            return [
                'code'    => '200',
                'message' => 'error',
                'reason'  => 'api key was not valid.'
            ];
        } else {
            $data = DB::select('SELECT inventories.*, IFNULL(inventories_stocks.stock,"") as stock FROM inventories LEFT JOIN inventories_stocks ON inventories_stocks.inventoriesId = inventories.id WHERE inventories.id='.$id);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $key, $sellerId, $id)
    {
        //
        if($key != $this->privateKey) {
            return [
                'code'    => '200',
                'message' => 'error',
                'reason'  => 'api key was not valid.'
            ];
        } else { 
            $invBelongTo = DB::table('inventories')->select('shopId')->where('id', $id)->value('user_id');
            if ($invBelongTo != $sellerId) {
                return [
                    'code'    => '500',
                    'message' => 'internal server error'
                ];
            } else {
                $image = $request->post('image');
                $name = $request->post('name');      
                $price = $request->post('price');
                $date = date("Y-m-d H:i:s");
                DB::table('inventories')->where('id', $id)->update(
                    [
                        'image' => $image,
                        'name' => $name,
                        'price' => $price,
                        'updated_at' => $date
                    ]
                );
                return [
                    'code'    => '200',
                    'message' => 'success'
                ];
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy($key, $sellerId, $id)
    {
        //
        if($key != $this->privateKey) {
            return [
                'code'    => '200',
                'message' => 'error',
                'reason'  => 'api key was not valid.'
            ];
        } else {
            $invBelongTo = DB::table('inventories')->select('shopId')->where('id', $id)->value('user_id');
            if ($invBelongTo != $sellerId) {
                return [
                    'code'    => '500',
                    'message' => 'internal server error'
                ];
            } else {
                DB::table('inventories')->where('id', $id)->delete();
                return [
                    'code'    => '200',
                    'message' => 'success'
                ];
            }
        }
    }
}
