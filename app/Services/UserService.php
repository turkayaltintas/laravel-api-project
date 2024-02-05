<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser(array $validatedData): User
    {
        if (Arr::exists($validatedData, 'password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        return User::create($validatedData);
    }
}
