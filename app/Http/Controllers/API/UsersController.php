<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
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
            $data = DB::select('SELECT * FROM users');
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
    public function store(Request $request, $key)
    {
        //
        if($key != $this->privateKey) {
            return [
                'code'    => '200',
                'message' => 'error',
                'reason'  => 'api key was not valid.'
            ];
        } else {
            $name = $request->post('name');
            $recognizer = $request->post('recognizer');
            $recognizerType = $request->post('recognizerType');
            $email = $request->post('email');      
            $password = $request->post('password');       
            $date = date("Y-m-d H:i:s");

            $count = DB::table('users')->select('id')->orderBy('id', 'desc')->limit(1)->value('id') + 1;

            $userEmail = DB::table('users')->where('email', $email)->first();
            $userRecognizer = DB::table('users')->where('recognizer', $recognizer)->first();
            
            if ($userEmail || $userRecognizer) {
                return [
                    'code'    => '500',
                    'message' => 'data already exist',
                ];
            } else {
                $validator = isset($name, $recognizer, $recognizerType, $email, $password, $date);
                if ($validator) {
                    DB::table('users')->insert(
                        [
                            'id' => $count,
                            'name' => $name, 
                            'recognizer' => $recognizer,
                            'recognizerType' => $recognizerType,
                            'email' => $email,
                            'password' => Hash::make($password),
                            'created_at' => $date,
                            'updated_at' => $date
                        ]
                    );
                    DB::table('user_roles')->insert(
                        [
                            'userId' => $count,
                            'userType' => 3
                        ]
                    );
                    DB::table('user_accounts')->insert(
                        [
                            'userId' => $count,
                            'balance' => 0
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
                        'reason'  => 'data incomplete'
                    ];
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
    public function showById($key, $id)
    {
        //
        if($key != $this->privateKey) {
            return [
                'code'    => '200',
                'message' => 'error',
                'reason'  => 'api key was not valid.'
            ];
        } else {
            $data = DB::select('SELECT users.id, users.name, users.recognizer, users.recognizerType, users.email, user_accounts.balance FROM users, user_accounts WHERE users.id='.$id.' and user_accounts.userId='.$id);
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

    public function showByEmail($key, $email)
    {
        //
        if($key != $this->privateKey) {
            return [
                'code'    => '200',
                'message' => 'error',
                'reason'  => 'api key was not valid.'
            ];
        } else {
            $userId = DB::table('users')->select('id')->where('email', $email)->value('user_email');
            $data = DB::select("SELECT users.id, users.name, users.recognizer, users.recognizerType, users.email, user_accounts.balance FROM users, user_accounts WHERE users.email='$email'".' and user_accounts.userId='.$userId);
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
            $uId = $request->post('id');
            $getId = DB::table('users')->select('id')->where('id', $id)->value('user_id');
            if ($getId != $uId) {
                return [
                    'code'    => '500',
                    'message' => 'internal server error'
                ];
            } else {
                $name = $request->post('name');      
                $email = $request->post('email');
                $date = date("Y-m-d H:i:s");
                DB::table('users')->where('id', $id)->update(
                    [
                        'name' => $name,
                        'email' => $email,
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
