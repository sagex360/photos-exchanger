<?php


namespace App\Http\Controllers\Client\Auth;


final class LoginController extends \App\Http\Controllers\Auth\LoginController
{
    public function showLoginForm()
    {
        return view('pages.client.auth.login');
    }
}
