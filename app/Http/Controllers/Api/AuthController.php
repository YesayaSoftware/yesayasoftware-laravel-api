<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ErrorResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validateUser = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]
        );

        if ($validateUser->fails()) {
            $response = new ErrorResponse($validateUser->errors());

            return response()->json(
                $response,
                ResponseAlias::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], ResponseAlias::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
        );

        if ($validateUser->fails()) {
            $response = new ErrorResponse($validateUser->errors());
            return response()->json(
                $response,
                ResponseAlias::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return "Validated";
    }
}
