<?php


namespace App\Http\Controllers\Client\Auth;


final class RegisterController extends \App\Http\Controllers\Auth\RegisterController
{
    public function showRegistrationForm()
    {
        return view('pages.client.auth.register');
    }
}
