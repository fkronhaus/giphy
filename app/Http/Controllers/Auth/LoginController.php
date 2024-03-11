<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function __construct()
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
            

            return response()->json(['message' => 'Autenticacion exitosa', 'token'=> $token, 'user_id' => $user["id"], 'username' => $user["name"]], 200);
        }else{
            return response()->json(['message' => 'Credenciales incorrectas' ], 401);
        }
    } 
    
    
    
    public function logout(Request $request)
    {
        Auth::logout();
        // borrar el token
        return response()->json(['message' => 'Sesion cerrada correctamente'], 200);
    }    



}