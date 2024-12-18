<?php

use Illuminate\Support\Facades\Auth;

if (! function_exists('isUserLoggedIn')) {
    function isUserLoggedIn()
    {
        return Auth::check();
    }
}
