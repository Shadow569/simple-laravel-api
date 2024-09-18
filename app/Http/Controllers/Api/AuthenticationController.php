<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegistrationFormRequest;
use Illuminate\Http\JsonResponse;

class AuthenticationController extends \App\Http\Controllers\Controller
{
    /**
     * @param \App\Http\Requests\RegistrationFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegistrationFormRequest $request): JsonResponse
    {
        \App\Models\User::create([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'password' => \Illuminate\Support\Facades\Hash::make($request->validated('password')),
        ]);

        return response()->json(["success" => true]);
    }

    /**
     * @param \App\Http\Requests\LoginFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginFormRequest $request): JsonResponse
    {
        $user = \App\Models\User::where('email', $request->validated('email'))->first();

        if (! $user || ! \Illuminate\Support\Facades\Hash::check($request->validated('password'), $user->password)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json(["token" => $user->createToken($request->ip())->plainTextToken]);
    }
}
