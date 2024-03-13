<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;

class LoginController extends Controller
{

    public function __construct(Request $request)
    {
        
    }

    public function home(Request $request){
        $userName = (Auth::user()) ? Auth::user()["name"] : "";

        return view('home', ['userName' => $userName]); 

    }



    public function authenticate(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


        
        if (Auth::attempt($credentials, true)) {

            $user = Auth::user();
            $token = $user->createToken("giphy", ["*"], Carbon::now()->addMinutes(env('TOKEN_EXPIRATION_TIME')));
            $token = $token->plainTextToken;
            
            $response =  ['message' => 'Autenticacion exitosa', 'token'=> $token, 'user_id' => $user["id"], 'username' => $user["name"]];
            $responseCode = 200;
            
        }else{
            $response =  ['message' => 'Credenciales incorrectas' ];
            $responseCode = 401;
        }
        
        Log::create( [ 'service' => $request->path(), 'user' => ($user) ? $user["id"]: null, 'request_body' => json_encode($request->all()), 'response_code' => $responseCode, 'response_body' => json_encode($response), 'source_ip' => $request->ip(), ] );
        
        return response()->json($response, $responseCode);
    } 
    
    
    
    public function logout(Request $request)
    {
        Auth::logout();
        // borrar el token
        return response()->json(['message' => 'Sesion cerrada correctamente'], 200);
    }    



}