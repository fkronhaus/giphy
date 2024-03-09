<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    private $token;
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'dashboard'
        ]);

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

            $user = User::where('email', $credentials['email'])
                        ->where('access_type', 1)
                        ->first();
            $token = $user->createToken("giphy", ["*"], Carbon::now()->addMinutes(30));
            $token = $token->plainTextToken;
            

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
        
        return response()->json(['message' => 'Autenticacion exitosa'], 200);
    }    



}