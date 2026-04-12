<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserService {

    public function __construct(
        private User $user,
    ) {}

    public function register(array $data) {
        $user = $this->user->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $token = explode('|', $user->createToken('accessToken')->plainTextToken)[1];
            return ['user' => $user, 'token' => $token];
        }
        return false;
    }

    public function login(array $data) {
        if(!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            throw ValidationException::withMessages(['email' => ['Incorrect email or password.']]);
        }
        $token = explode('|', Auth::user()->createToken('accessToken')->plainTextToken)[1];
        return ['user' => Auth::user(), 'token' => $token];
    }

    public function me(): User {
        return Auth::user();
    }

    public function logout() {
        return Auth::user()->currentAccessToken()->delete();
    }
}
