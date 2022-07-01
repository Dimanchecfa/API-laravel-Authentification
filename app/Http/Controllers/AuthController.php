<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $req)
        {
            //validate
            $rules=[
                'username'=>'required|string',
                'email'=>'required|email|unique:users|string',
                'password'=>'required|min:6|string'
            ];
            $validator = Validator::make($req->all(),$rules);
            if($validator->fails()){
                return response()->json($validator->errors(),400);
            }
            //create user
            $user = User::create([
                'username'=>$req->username,
                'email'=>$req->email,
                'password'=>Hash::make($req->password)
            ]);
            $token = $user->createToken('Personal Acces Token')->accessToken;
            $response = ['user'=>$user,'token'=>$token];
            return response()->json($response,200);
         

        }

        public function login(Request $req)
        {
            $rules=[
                'email'=>'required|email',
                'password'=>'required|min:6',
            ];
           $req->validate($rules);
              $user = User::where('email',$req->email)->first();    
              if($user && Hash::check($req->password,$user->password)){
                  $token = $user->createToken('Personal Acces Token')->accessToken;
                  $response = ['user'=>$user,'token'=>$token];
                  return response()->json($response,200);
              }
              $response = ['message' => 'email ou mot de passe invalide' ];
                return response()->json($response,400);
       }
        }

    


    //

