<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Registers a client that will consume the API.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $user_data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $user_data['password'] = Hash::make($user_data['password']);
        $user = User::create($user_data);
        $token = $user->createToken('API Token')->accessToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ], 201);
    }

    /**
     * Logs a user into the system.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'email|required',
            'password' => 'required',
        ]);

        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => 'Incorrect credentials'], 422);
        }

        $token = auth()->user()->createToken('API Token')->accessToken;

        return response()->json([
            'user'  => auth()->user(),
            'token' => $token,
        ]);
    }

    /**
     * Logs a user out of the system.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

        return response()->json();
    }
}
