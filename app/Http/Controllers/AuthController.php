<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

      public function index()
    {
          return StudentResource::collection(User::orderByDesc('created_at')->get());
    }

     public function show(User $user)
    {
         return new StudentResource($user);
    }

    public function update(Request $request,User $user)
    {
         if ($user->update($request->all())) {
            return response()->json([
                'success' => 'Informations modifiée avec succès'
            ], 200);
        }
        
    }


    public function register(Request $req)
        {
            //validate
            $rules=[
                'nom'=>'required|string',
                'prenom'=>'required|string',
                'email'=>'required|email|unique:users|string',
                'password'=>'required|min:6|string'
            ];
            $validator = Validator::make($req->all(),$rules);
            if($validator->fails()){
                return response()->json($validator->errors(),400);
            }
            //create user
            $user = User::create([
                'nom'=>$req->nom,
                'prenom'=>$req->prenom,
                'email'=>$req->email,
                'password'=>Hash::make($req->password)
            ]);
            $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'user_id' =>$user->id,
                    'acces_token'=> $token ,
                    'token_type' => 'Bearer',
                ]);
         

        }

       public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Email ou mot de passe incorrect'
            ], 401);
        }

            $user = User::where('email', $request['email'])->firstOrFail();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
            'user_id' => $user->id,
            'access_token' => $token,
            'token_type' => 'Bearer',
            ]);
    }


     //recuperation de l'utilisateur connecté en temps reel
    public function me(Request $request)
    {
        return $request->user();
    }

    


}