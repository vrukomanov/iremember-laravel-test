<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use HttpResponse;

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->error(data: $validator->errors()->messages(), code: 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->error(message: 'Bad credentials');
        }

        $token = $user->createToken('iremember')->plainTextToken;

        $response = [
            'user' => [
                'name' => $user->name,
                'created' => $user->created_at
            ],
            'token' => $token
        ];

        return $this->success($response, 'Logged in successfully', 201);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return $this->success(message: 'Logged out');
    }
}
