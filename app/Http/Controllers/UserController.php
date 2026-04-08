<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Traits\Api\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    use ApiResponse;

    public function __construct(
        private UserService $userService,
    ) {}

    public function register(Request $request) {
        try {
            $input = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
            ]);
            $result = $this->userService->register($input);
            if($result) {
                return $this->successResponse($result, 'User registered successfully.', 201);
            }
            return $this->errorResponse('Failed to register user.', 500);
        } catch(ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422);
        } catch (Exception $e) {
            return $this->errorResponse('Failed to register user.', 500);
        }
    }

    public function login(Request $request) {
        try {
            $input = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);
            $result = $this->userService->login($input);
            return $this->successResponse($result, '', 200);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422);
        } catch (Exception $e) {
            return $this->errorResponse('Failed to login user.', 500);
        }

    }

    public function me() {
        try {
            $result = $this->userService->me();
            return $this->successResponse($result, '', 200);
        } catch(Exception $e) {
            return $this->errorResponse("{$e->getLine()}: {$e->getMessage()}", 500);
        }
    }

    public function logout() {
        try {
            $this->userService->logout();
            return $this->successResponse(null, 'User logged out successfully.', 200);
        } catch (Exception $e) {
            return $this->errorResponse('Failed to logout user.', 500);
        }
    }
}