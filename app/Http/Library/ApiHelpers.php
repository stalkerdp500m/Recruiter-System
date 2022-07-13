<?php

namespace App\Http\Library;

use Illuminate\Http\JsonResponse;

trait ApiHelpers
{
    protected function isCan($user, $abilites): bool
    {
        if (!empty($user)) {
            return $user->tokenCan($abilites);
        }
        return false;
    }
    protected function onSuccess($data, string $message = '', int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    protected function onError(int $code, string $message = ''): JsonResponse
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
        ], $code);
    }
    protected function salaryValidationRules(): array
    {
        return [
            'data.*.year' => 'required',
            'data.*.month' => 'required',
            'data.*.client_pasport' => 'required',
            'data.*.client_name' => 'required',
        ];
    }
    protected function userValidatedRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
