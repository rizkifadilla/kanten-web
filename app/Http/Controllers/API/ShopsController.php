<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ShopsController extends Controller
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
            $data = DB::select('SELECT * FROM shops');
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
     * Display the specified resource.
     *
     * @param  int  $id
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
            $data = DB::select('SELECT * FROM shops WHERE id='.$id);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $key, $id)
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
}
