<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request){
        
        $cred = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ]
        );

        $user = User::where('email', $cred['email'])
                    ->where('password', bcrypt($cred['password']))
                    ->first();

        if ($user){
            return response()->json(['message' => 'Autenticacion exitosa', 'user' => $user], 200);
        }else{
            return response()->json(['message' => 'Credenciales incorrectas. Pass:'.$cred['password']. bcrypt($cred['password'])], 401);
        }
        
    }
}
