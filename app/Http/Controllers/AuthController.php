<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponser;

    public function register(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'identificacion' => 'required|numeric',
            'telefono' => 'required|numeric',
        ]);

        $user = User::create([
            'name' => $attr['name'],
            'password' => bcrypt($attr['password']),
            'email' => $attr['email'],
            'identificacion' => $attr['identificacion'],
            'telefono' => $attr['telefono'],
        ]);

        return $this->success([
            'token' => $user->createToken('API Token')->plainTextToken
        ]);
    }

    public function login(Request $request)
    {

        if (!Auth::attempt($request->only('email','password'))) {
            return response()->json(['error' => 'Invalid login details'], 401);
        }

        if(Auth::attempt($request->only('email','password'))){
            $response = User::select('estado')
                        ->where('email', $request->email)
                        ->first();

            if ($response->estado == 2) {
                return response()->json([
                    'acces_token' => auth()->user()->createToken('API Token')->plainTextToken,
                    'token_type' => 'Bearer',
                ]);

            }else{
                return response()->json(['error' => 'Los datos del usuario aún no han sido validados'], 401);
            }
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'successfully logged out']);

    }
}
