<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'dashboard'
        ]);
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
            $token = $user->createToken("example");

            return response()->json(['message' => 'Autenticacion exitosa', 'token'=> $token->plainTextToken], 200);
        }else{
            return response()->json(['message' => 'Credenciales incorrectas' ], 401);
        }
    } 
    
    
    
    public function logout(Request $request)
    {
        Auth::logout();
        // borrar el token
        return response()->json(['message' => 'Autenticacion exitosa'], 200);
    }    



}