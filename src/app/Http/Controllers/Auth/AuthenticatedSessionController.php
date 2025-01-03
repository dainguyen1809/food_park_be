<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && ($user->google_id || $user->facebook_id)) {
            Auth::login($user);
        } else {
            $request->authenticate();
        }

        $token = $request->session()->regenerate();

        $redirectUrl = match (Auth::user()->role) {
            'admin' => env('FRONTEND_URL').'/admin/dashboard',
            'user' => env('FRONTEND_URL').'/dashboard',
            default => env('FRONTEND_URL').'/dashboard',
        };

        return response()->json([
            'message' => 'Login successful.',
            // 'redirect_url' => $redirectUrl,
            'role' => Auth::user()->role
        ], 200);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([
            'statusCode' => 200,
            'message' => 'Logout successfully.',
        ], 200);
    }
}
