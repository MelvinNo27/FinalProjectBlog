<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Redirect authenticated users based on their role.
     */
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login'); // Ensure only authenticated users proceed
        }

        return Auth::user()->role === 'admin'
            ? redirect()->route('admin#home')
            : redirect()->route('user#home'); // Redirect admins and users accordingly
    }
}
