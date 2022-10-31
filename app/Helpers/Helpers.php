<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Helper {

    public function __construct(){}


    /**
     * example
     * Adds a new item to the cart.
     *
     * @param string $id
     * @param string $name
     * @param string $price
     * @param string $quantity
     * @param array $options
     * @return void
     */

    public static function test(){
        return "testing...  ";
    }

    public static function validatorRegisterUser(Request $request){
        $validator = Validator::make($request->all(), [
            'name'          => 'required|unique:users',
            'email'         => 'required|email|unique:users',
            'password'      => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'from'    => 'validatorRegisterUser skankhunt',
                'message' => $validator->errors(),
            ], 401);
        }
    }

    public static function validatorParams(Array $params){
        $validator = Validator::make($params, [
            'client_id'     => 'required',
            'client_secret' => 'required',
            'grant_type'    => 'required',
            'username'      => 'required',
            'password'      => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'from'    => 'validatorParams skankhunt',
                'message' => $validator->errors(),
            ], 401);
        }    
    }

    public static function getUrlProviderOauth() : string{
        $APP_OAUTH_PROVIDER = $_ENV['APP_OAUTH_PROVIDER'];
        return $APP_OAUTH_PROVIDER;
    }

    public static function getUrlProviderRest() : string{
        $APP_REST_PROVIDER = $_ENV['APP_REST_PROVIDER'];
        return $APP_REST_PROVIDER;
    }   


}