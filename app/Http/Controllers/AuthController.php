<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'name' => ['required','string'],
            'email' => ['required','email',Rule::unique('users','email')],
            'password' => ['required','string','confirmed']
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response,201);
    }

    public function logout(Request $request){
        \auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged Out'
        ];
    }

    public function login(Request $request)
    {
        $fields = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad cred'
            ]);
        } else {
            $token = $user->createToken('myapptoken')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

            return response($response, 201);
        }
    }
}

