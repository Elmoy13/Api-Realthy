<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{
    public function login(Request $request)
    {

      if (!Auth::attempt($request->only('email','password'))) {
           return response()->json([
            'message'=>'Correo o contraseña incorrectos',
            'status'=>  false
        ],400);
        }

        $user = User::where('email',$request['email'])->firstOrFail();

        $token = $user->createToken('web')->plainTextToken;


        return response()->json([

            'data'=>  $user,
            'token'=>$token
        ]);

    }

    public function logout(Request $request)
    {
        // auth()->user()->tokens()->delete();
        $request->user()->currentAccessToken()->delete();

        return response()->json([

            'status'=> true,

        ]);
    }

    public function register(Request $request)
    {
        $data = $request->json()->all();

        $itExistsUserName=User::where('email',$data['email'])->first();

        if ($itExistsUserName==null) {
            $user = User::create(
                [
                    'name'=>$data['name'],
                    'email'=>$data['email'],
                    'password'=>Hash::make($data['password'])

                ]
            );

            $token = $user->createToken('web')->plainTextToken;


                return response()->json([
                    'data'=>$user,
                    'token'=> $token

                ],200);
        } else {
               return response()->json([
                'data'=>'User already exists!',
                'status'=> false

            ],200);
       }

   }


}
