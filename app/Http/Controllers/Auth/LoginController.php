<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;



class LoginController extends Controller
{

    private $token;
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'dashboard'
        ]);

        $this->token =  Cookie::get('giphy_token');
    }

    public function home(){

        return view('home' , ['token' => $this->token]); 

    }



    public function authenticate(Request $request)
    {
        
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


        
        if (Auth::attempt($credentials)) {
            //guardar el token

            $user = User::where('email', $credentials['email'])->first();
            $token = $user->createToken("giphy", ["*"], Carbon::now()->addMinutes(30));
            $token = $token->plainTextToken;
            Cookie::make("giphy_token", $token, 30);

            return response()->json(['message' => 'Autenticacion exitosa', 'token'=> $token], 200);
        }else{
            return response()->json(['message' => 'Credenciales incorrectas' ], 401);
        }
    } 
    
    
    
    public function logout(Request $request)
    {
        Auth::logout();
        // borrar el token
        //$this->user->tokens()->delete();
        Cookie::forget('user-cookie');
        return response()->json(['message' => 'Autenticacion exitosa'], 200);
    }    



}