<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request){
        //1. Setup Validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8'
        ]);

        //2. Cek Validator
        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }


        //3. Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        //4. Cek keberhasilan
        if ($user) {
            return response()->json([
                'succsess' => true,
                'message' => 'User created succsessfully',
                'data' => $user
            ], 201);
        }

        //5. Cek gagal
        return response()->json([
            'success' => false,
            'message' => 'User creation failed'
        ], 409); //conflict
    }

    public function login(Request $request) {
        //1.Setuo Validator
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //2.Cek validator
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //3.Get kridensial dari request
        $credetials = $request->only('email', 'password');

        //4.Cek isFailed
        if (!$token = auth()->guard('api')->attempt($credetials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password Anda salah!'
            ], 401);
        }

        //5.Cek isSuccesss
        return response()->json([
            'success' => true,
            'message' => 'Login successfuly',
            'user' => auth()->guard('api')->user(),
            'token' => $token
        ], 200);
    }

    public function logout(Request $request) {
        // try 
        //1. Invalidated token
        //2. Cek isSuccess

        //catch
        //1. Cek isFailed
        
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'success' => true,
                'message' => 'Logout successfully'
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Logout failed!'
            ], 500);
        }
    }
}
