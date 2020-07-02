<?php


namespace App\Http\Controllers\Client\Auth;


use App\Exceptions\UserAuthenticationFailed;
use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Login\LoginClientRequest;
use App\Providers\RouteServiceProvider;
use App\Services\Auth\Login\LoginClientCommand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

final class LoginController extends Controller
{
    /** @var LoginClientCommand */
    protected $command;

    public function __construct(LoginClientCommand $command)
    {
        $this->command = $command;
    }

    public function showLoginForm()
    {
        return view('pages.client.auth.login');
    }

    /**
     * @param LoginClientRequest $request
     * @return RedirectResponse
     */
    public function login(LoginClientRequest $request)
    {
        try {
            $this->command->login($request->createDto());

        } catch (UserNotFoundException|UserAuthenticationFailed $e) {
            return redirect()->back()
                ->withErrors(['login' => trans('auth.failed')])
                ->withInput();
        }

        return redirect()->route(
            RouteServiceProvider::homeRoute($this->command->getGuard())
        );
    }

    public function logout()
    {
        $this->command->logout(Auth::user());

        return redirect()->route(RouteServiceProvider::loginRoute($this->command->getGuard()));
    }
}
