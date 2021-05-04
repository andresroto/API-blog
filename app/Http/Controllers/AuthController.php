<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    
    public function login(Request $request)
    {

        try {
            
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required|string'
            ]); 

            $credentials = $request->only(['email', 'password']); 
            
            if( !Auth::attempt($credentials) ) {
                return response()->json([
                    'Message' => 'Incorrect data...'
                ]);
            }

            $user = $request->user(); 
            $token = $user->createToken('Access Personal Token'); 
            $tokenResult = $token->token; 
            $tokenResult->save(); 

            return response()->json([
                'access_token' => $token->accessToken, 
                'token_type' => 'Bearer'
            ]); 
                
        } catch (ValidationException $e) {
           
            return response()->json([
                $e->validator->errors()
            ]); 
        }

    }


    public function user(Request $request)
    {
        return response()->json([
            'User' => new UserResource($request->user())
        ]); 
    }


    public function logout(Request $request)
    {
        $request->user()->token()->revoke(); 
        return response()->json([
            'Message' => 'Success Logout'
        ]); 
    }

}
