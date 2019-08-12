<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all($key)
    {
        //
        if($key != $this->privateKey) {
            return [
                'code'    => '200',
                'message' => 'error',
                'reason'  => 'api key was not valid.'
            ];
        } else {
            $data = DB::select('SELECT * FROM transactions');
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
    public function payment(Request $request, $key)
    {
        //
        $sender = $request->post('sender');
        $recepient = $request->post('recepient');
        $type = $request->post('type');
        $client = $request->post('client');
        $balanceUsed = $request->post('balanceUsed');

        $invId = $request->post('invId');
        $invQty = $request->post('invQty');
        
        $date = date("Y-m-d H:i:s");

        if($key != $this->privateKey) {
            return [
                'code'    => '200',
                'message' => 'error',
                'reason'  => 'api key was not valid.'
            ];
        } else {
            $validator = isset($sender, $recepient, $type, $client, $balanceUsed, $invId, $invQty);

            if ($validator) {
                $count = DB::table('transactions')->select('id')->orderBy('id', 'desc')->limit(1)->value('id') + 1;
                $sellerId = DB::table('shops')->select('sellerId')->where('id', $recepient)->value('shop_id');
                $shopStatus = DB::table('shops')->select('isOpen')->where('sellerId', $sellerId)->value('shop_status');
                $invStatus = DB::table('inventories_stocks')->select('stock')->where('inventoriesId', $invId)->value('inv_status');
                $userId = DB::table('users')->select('id')->where('email', $sender)->value('user_id');
                $userBalance = DB::table('user_accounts')->select('balance')->where('userId', $userId)->value('user_balance');

                $invType = DB::table('inventories')->select('inventoriesType')->where('id', $invId)->value('inv_type');
                
                $bU = (int)$balanceUsed;
                $uB = (int)$userBalance;
                
                $iS = (int)$invStatus;
                $iQ = (int)$invQty;

                if ($shopStatus == 1) {
                    if ($invType == 1) {
                        if ($iS >= $iQ) {
                            if ($uB >= $bU) {
                                DB::table('transactions')->insert(
                                    [
                                        'id' => $count,
                                        'sender' => $userId,
                                        'recepient' => $sellerId, 
                                        'type' => $type,
                                        'client' => $client,
                                        'balanceUsed' => $balanceUsed,
                                        'created_at' => $date,
                                        'updated_at' => $date
                                    ]
                                );
                                DB::table('shop_transactions')->insert(
                                    [
                                        'transactionId' => $count,
                                        'inventoriesId' => $invId,
                                        'inventoriesQty' => $invQty, 
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
                                    'message' => 'error',
                                    'reason'  => 'sender have insufficient balance'
                                ];
                            }
                        } else {
                            return [
                                'code'    => '500',
                                'message' => 'error',
                                'reason'  => 'shops have insufficient stock'
                            ];
                        }
                    } else if ($invType == 2) {
                        if ($uB >= $bU) {
                            DB::table('transactions')->insert(
                                [
                                    'id' => $count,
                                    'sender' => $userId,
                                    'recepient' => $sellerId, 
                                    'type' => $type,
                                    'client' => $client,
                                    'balanceUsed' => $balanceUsed,
                                    'created_at' => $date,
                                    'updated_at' => $date
                                ]
                            );
                            DB::table('shop_transactions')->insert(
                                [
                                    'transactionId' => $count,
                                    'inventoriesId' => $invId,
                                    'inventoriesQty' => $invQty, 
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
                                'message' => 'error',
                                'reason'  => 'sender have insufficient balance'
                            ];
                        }
                    }
                } else {
                    return [
                        'code'    => '500',
                        'message' => 'error',
                        'reason'  => 'shops unavailable, status '.$shopStatus
                    ];
                }
            } else {
                return [
                    'code'    => '500',
                    'message' => 'error',
                    'reason'  => 'data incomplete'
                ];
            }
        }
    }

    public function transfer(Request $request, $key)
    {
        //
        $sender = $request->post('sender');
        $recepient = $request->post('recepient');
        $type = $request->post('type');
        $client = $request->post('client');
        $balanceUsed = $request->post('balanceUsed');
        
        $date = date("Y-m-d H:i:s");
        
        $bU = (int)$balanceUsed;

        if($key != $this->privateKey) {
            return [
                'code'    => '200',
                'message' => 'error',
                'reason'  => 'api key was not valid.'
            ];
        } else {
            if ($recepient == $sender) {
                return [
                    'code'    => '500',
                    'message' => 'error',
                    'reason'  => 'transfer not allowed'
                ];
            } else {
                if ($bU < 500) {
                    return [
                        'code'    => '500',
                        'message' => 'error',
                        'reason'  => 'transfer not allowed'
                    ];
                } else {
                    $validator = isset($sender, $recepient, $type, $client, $balanceUsed);

                    if ($validator) {
                        $recepientEmail = DB::table('users')->where('email', $recepient)->first();
                        if (!$recepientEmail) {
                            return [
                                'code'    => '500',
                                'message' => 'error',
                                'reason'  => 'recepient doesnt exist'
                            ];
                        } else {
                            $senderId = DB::table('users')->select('id')->where('email', $sender)->value('user_id');
                            $recepientId = DB::table('users')->select('id')->where('email', $recepient)->value('user_id');
                            $senderBalance = DB::table('user_accounts')->select('balance')->where('userId', $senderId)->value('sender_balance');
                            $recepientBalance = DB::table('user_accounts')->select('balance')->where('userId', $recepientId)->value('recepient_balance');
                            
                            $sB = (int)$senderBalance;
                            $rB = (int)$recepientBalance;

                            if ($sB >= $bU) {
                                DB::table('transactions')->insert(
                                    [
                                        'sender' => $senderId,
                                        'recepient' => $recepientId, 
                                        'type' => $type,
                                        'client' => $client,
                                        'balanceUsed' => $bU,
                                        'created_at' => $date,
                                        'updated_at' => $date
                                    ]
                                );
                                DB::table('user_accounts')->where('userId', $senderId)->update(
                                    [
                                        'balance' => $sB - $bU
                                    ]
                                );
                                DB::table('user_accounts')->where('userId', $recepientId)->update(
                                    [
                                        'balance' => $rB + $bU
                                    ]
                                );
                                return [
                                    'code'    => '200',
                                    'message' => 'success'
                                ];
                            } else {
                                return [
                                    'code'    => '500',
                                    'message' => 'error',
                                    'reason'  => 'sender have insufficient balance'
                                ];
                            }
                        }
                    } else {
                        return [
                            'code'    => '500',
                            'message' => 'error',
                            'reason'  => 'data incomplete'
                        ];
                    }
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showByShopId($key, $id)
    {
        //
        if($key != $this->privateKey) {
            return [
                'code'    => '200',
                'message' => 'error',
                'reason'  => 'api key was not valid.'
            ];
        } else {
            $data = DB::select('SELECT * FROM transactions WHERE id='.$id);
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

    public function showByUserEmail($key, $email)
    {
        //
        if($key != $this->privateKey) {
            return [
                'code'    => '200',
                'message' => 'error',
                'reason'  => 'api key was not valid.'
            ];
        } else {
            $id = DB::table('users')->select('id')->where('email', $email)->value('user_id');
            $data = DB::select("SELECT transactions.id, (SELECT users.name FROM users WHERE users.id = transactions.sender LIMIT 1) as sender, (SELECT users.name FROM users WHERE users.id = transactions.recepient LIMIT 1) as recepient, transactions.type, (SELECT clients.type FROM clients WHERE clients.id = transactions.client) as client, transactions.balanceUsed, transactions.created_at FROM transactions WHERE transactions.sender = $id or transactions.recepient = $id ORDER BY transactions.created_at DESC");
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

    public function showInventoriesByTransaction($key, $id) {
        if($key != $this->privateKey) {
            return [
                'code'    => '200',
                'message' => 'error',
                'reason'  => 'api key was not valid.'
            ];
        } else {
            $data = DB::select("SELECT inventories.* FROM inventories, shop_transactions WHERE inventories.id = shop_transactions.inventoriesId AND shop_transactions.transactionId = $id");
            return [
                'code'    => '200',
                'message' => 'success',
                'results' => $data
            ];
        }
    }

    public function showByUserId($key, $id)
    {
        //
        if($key != $this->privateKey) {
            return [
                'code'    => '200',
                'message' => 'error',
                'reason'  => 'api key was not valid.'
            ];
        } else {
            $data = DB::select('SELECT * FROM transactions WHERE id='.$id);
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
