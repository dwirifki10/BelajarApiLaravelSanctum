<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if(!$user || !\Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'password invalid'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('token-name')->plainTextToken;

        return response()->json([
            'message' => 'password valid',
            'user' => $user,
            'token' => $token
        ], Response::HTTP_OK);
    }
}
