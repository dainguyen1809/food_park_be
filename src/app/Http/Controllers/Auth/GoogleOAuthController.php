<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Google_Client;

class GoogleOAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return response()->json([
            'redirect_url' => Socialite::driver('google')->stateless()->redirect()->getTargetUrl()
        ]);
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => str()->password(10)
            ]
        );
        // Đăng nhập
        auth()->login($user);

        return redirect(config('app.frontend_url'));
    }

    public function handleOneTapCallback(Request $request)
    {
        $client = new Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
        $payload = $client->verifyIdToken($request->credential);

        if ($payload) {
            $user = User::updateOrCreate(
                ['email' => $payload['email']],
                [
                    'name' => $payload['name'],
                    'google_id' => $payload['sub'],
                    'avatar' => $payload['picture'],
                ]
            );

            Auth::login($user);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 401);
    }
}
