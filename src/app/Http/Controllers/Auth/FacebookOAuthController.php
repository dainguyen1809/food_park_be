<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class FacebookOAuthController extends Controller
{
    public function redirectToFacebook()
    {
        try {
            $url = Socialite::driver('facebook')
                ->scopes(['public_profile', 'email'])
                ->stateless()
                ->redirect()
                ->getTargetUrl();

            return response()->json(['url' => $url], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->stateless()->user();
            $findUser = User::where('facebook_id', $user->id)->first();

            if ($findUser) {
                Auth::login($findUser);

                $redirectUrl = config('app.frontend_url').'/test';
                return redirect($redirectUrl);

            } else {
                $newUser = User::updateOrCreate(['email' => $user->email], [
                    'name' => $user->name,
                    'facebook_id' => $user->id,
                    'password' => bcrypt(str()->password(10))
                ]);

                Auth::login($newUser);

                $redirectUrl = config('app.frontend_url').'/test';
                return redirect($redirectUrl);

            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Facebook login failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
