<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Session\SessionManager;
use GuzzleHttp\Client;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;

class Services {

    public function __construct(){}


    public static function obtenerPosts(){

        $APP_REST_PROVIDER = Helper::getUrlProviderRest();
        $client = new Client();
        try{

            $params = [];

            $response = $client->request('GET', $APP_REST_PROVIDER.'/api/rest/obtenerPosts',['form_params' => $params]);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();
    
            $json =  json_decode($body,true);
    
            return response($json,200);

        }catch (ClientException $exception) {
            return $exception;
        }
    }


    /**
     * example
     * get login data
     *
     * @param Request $request
     * @return array
     */
    public static function getLoginService(Request $request){

        $APP_SKANKHUNT_PROVIDER = Helper::getUrlProviderSkankHunt();
        $client = new Client();
        try{
            $params = [
                "client_id"     => $request -> client_id,
                "client_secret" => $request -> client_secret,
                "grant_type"    => $request -> grant_type,
                "username"      => $request -> username,
                "password"      => $request -> password
            ];

            $response = $client->request('POST', $APP_SKANKHUNT_PROVIDER.'/api/public/getLogin',['form_params' => $params]);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();
    
            $json =  json_decode($body,true);   // returns an array
    
            return response($json,200);
        }
        catch (ClientException $exception) {
            return $exception;
        }
    }


        /**
     * example
     * get login data
     *
     * @param Request $request
     * @return array
     */
    public static function getRegisterService(Request $request){
        
        $APP_SKANKHUNT_PROVIDER = Helper::getUrlProviderSkankHunt();
        $client = new Client();

        try{
            $params = [
                "name"          => $request -> name,
                "email"         => $request -> email,
                "password"      => $request -> password,

                "client_id"     => $request -> client_id,
                "client_secret" => $request -> client_secret,
                "grant_type"    => $request -> grant_type
            ];

            $response = $client->request('POST', $APP_SKANKHUNT_PROVIDER.'/api/public/getRegister',['form_params' => $params]);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();
    
            $json =  json_decode($body,true);   // returns an array
    
            return response($json,200);
        }
        catch (ClientException $exception) {
            return $exception;
        }


    }
    

}