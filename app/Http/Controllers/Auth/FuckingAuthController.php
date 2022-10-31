<?php
namespace App\Http\Controllers\Auth;

use App\Helpers\Helper as HelpersHelper;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Services;

use GrahamCampbell\ResultType\Success;

use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;

class FuckingAuthController extends Controller
{


    public function getLogin(Request $request){

        $MY_REQUEST= new Request();
        $MY_REQUEST->setMethod('POST');
        
        $params = [
            "client_id"     => $request -> client_id,
            "client_secret" => $request -> client_secret,
            "grant_type"    => $request -> grant_type,
            "username"      => $request -> username,
            "password"      => $request -> password
        ];

        
        $validacion = Helper::validatorParams($params);
        if($validacion){
            $MY_REQUEST->request->add(["error"=>$validacion]);
            return $MY_REQUEST;
        }
        
        $MY_REQUEST->request->add($params);
        
        $result               = $this->getPasswordGrantToken($MY_REQUEST); //asincronico
        $response             = ['result' => $result];
        
        return $response;
        
    }

    public function getLogout(Request $request){

        $tokenRepository        = app(TokenRepository::class);
        $refreshTokenRepository = app(RefreshTokenRepository::class);

        //return  $request->header('Authorization');

        //found $user
        $tokenBearer            = $request->header('Authorization');
        $user                   = User::where('name', '=', $request['name'])->first();
        $tokenId = "";

        if($user!=null && $tokenBearer!=null){
            $tokenBearerArray   = explode(" ",$tokenBearer);
            $auth_header        = explode('.', $tokenBearerArray[1]);
            $token              = $auth_header[1];
            $token_header_json  = base64_decode($token);
            $token_header_array = json_decode($token_header_json, true);
            
            if($token_header_array["jti"]!=null){
                $tokenId = $token_header_array["jti"];
            }
        }
        if($tokenId!=""){
            // Revoke user token
            $tokenRepository->revokeAccessToken($tokenId);
            // Revoke all of the token's refresh tokens...
            $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);

            return response()->json([
                'success' => true,
                'from'    => 'skankhunt',
                'message' => 'tokenId revoked',
            ], 200); 
        }else{
            return response()->json([
                'success' => false,
                'from'    => 'skankhunt',
                'message' => 'tokenId no encontrado',
            ], 401);
        }
    }

    public function revokeUserToken(){

    }



    // CREATE ANY GRANT_TYPE
    public function getRegister (Request $request) {

        $MY_REQUEST= new Request();
        $MY_REQUEST->setMethod('POST');

        //return $request;

        $validacion = Helper::validatorRegisterUser($request);
        if($validacion){
            $MY_REQUEST->request->add(["error"=>$validacion]);
            return $MY_REQUEST;
        }

        //GET TOKEN DEL USUARIO
        $params = [
            "client_id"     => 1,
            "client_secret" => $request -> client_secret,
            "grant_type"    => $request -> grant_type,
            "username"      => $request -> email,
            "password"      => $request -> password
        ];
        
        $validacion2 = Helper::validatorParams($params);
        if($validacion2){
            $MY_REQUEST->request->add(["error"=>$validacion2]);
            return $MY_REQUEST;
        }

        //crear el usuario
        $request['password']    = bcrypt($request['password']); //si o si se debe de encriptar para que oauth reconozca
        $user                   = User::create($request->toArray());

        //creando request para generar el token
        $MY_REQUEST = new Request();
        $MY_REQUEST->setMethod('POST');
        $MY_REQUEST->request->add($params);

        //$result             = $user->createToken('Password Grant Client')->accessToken;
        $result               = $this->getPasswordGrantToken($MY_REQUEST); //asincronico
        
        $response               = [ 
                                    'user '     => $user,
                                    'token'     => $result,
                                    'params'    => $params,
                                    'permisos'  => [],
                                    'app'       => []
                                  ];
        
        return response($response, 200);

    }

    public function getPasswordGrantToken (Request $request) {  

        $grant_type = "password";
        
        $params = [
            "client_id"     => $request -> client_id,
            "client_secret" => $request -> client_secret,
            "grant_type"    => $grant_type,
            "username"      => $request -> username,
            "password"      => $request -> password
        ];
        
        $APP_OAUTH_PROVIDER = Helper::getUrlProviderOauth();
        
        //return $APP_OAUTH_PROVIDER;

        $client = new Client();
        $response = $client->request('POST', $APP_OAUTH_PROVIDER.'/oauth/token',['form_params' => $params]);
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        $json =  json_decode($body,true);   // returns an array

        return response($json,200);

    }


    
}
