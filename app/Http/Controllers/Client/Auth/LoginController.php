<?php


namespace App\Http\Controllers\Client\Auth;


use App\Exceptions\UserAuthenticationFailed;
use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Login\LoginClientRequest;
use App\Providers\RouteServiceProvider;
use App\Services\Auth\GuardResolver;
use App\Services\Auth\Login\LoginClientCommand;
use Illuminate\Support\Facades\Auth;

final class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.client.auth.login');
    }

    /**
     * @param LoginClientRequest $request
     * @param LoginClientCommand $command
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginClientRequest $request, LoginClientCommand $command)
    {
        try {
            $command->login($request->createDto());

        } catch (UserNotFoundException|UserAuthenticationFailed $e) {
            return redirect()->back()
                ->withErrors(['login' => trans('auth.failed')])
                ->withInput();
        }

        return redirect()->route(
            RouteServiceProvider::homeRoute($command->getGuard())
        );
    }
}
