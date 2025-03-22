<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\BlackList;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        $validator = Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'gender' => ['required', 'in:male,female'],
            'password' => $this->passwordRules(),
        ]);

        $validator->validate();

        // Check if email is blacklisted
        $blacklisted = BlackList::where('email', $input['email'])->exists();

        if (!$blacklisted) {
            return User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'gender' => $input['gender'],
                'password' => Hash::make($input['password']),
                'role' => 'user', // Default role set to "user"
            ]);
        }
    }
}
