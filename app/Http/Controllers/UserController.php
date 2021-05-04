<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()) {

            try {
                
                // Validations 
                $this->validate($request, [
                    'name' => 'required|string|max:255', 
                    'email' => 'required|email', 
                    'password' => 'required|string'
                ]);

                // Save fields
                $user = new User; 
                $user->name = $request->name; 
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->save();

                // Return response
                return response()->json([
                    'Message' => 'Ok', 
                    'User' => new UserResource($user) 
                ]); 
            
            } catch (ValidationException $e) {
                return response()->json(
                    $e->validator->errors()
                ); 
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if($request->ajax()) {

            try {
                
                // Validations 
                $this->validate($request, [
                    'name' => 'required|string|max:255', 
                    'email' => 'required|email', 
                    'password' => 'required|string'
                ]);

                // Save fields
                $user->name = $request->name; 
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->save();

                // Return response
                return response()->json([
                    'Message' => 'Ok', 
                    'User' => new UserResource($user) 
                ]); 
            
            } catch (ValidationException $e) {
                return response()->json(
                    $e->validator->errors()
                ); 
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete(); 
        return response()->json([
            'Message' => 'Ok', 
            'User' => $user
        ]); 
    }
}
