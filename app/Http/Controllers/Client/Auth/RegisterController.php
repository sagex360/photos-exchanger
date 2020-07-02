<?php


namespace App\Http\Controllers\Client\Auth;


use App\Exceptions\UserWithGivenEmailAlreadyExists;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Register\RegisterClientRequest;
use App\Services\Auth\Register\RegisterClientCommand;
use Illuminate\Http\RedirectResponse;

final class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('pages.client.auth.register');
    }

    /**
     * @param RegisterClientRequest $request
     * @param RegisterClientCommand $registerUserCommand
     * @return RedirectResponse
     */
    public function register(RegisterClientRequest $request, RegisterClientCommand $registerUserCommand)
    {
        try {
            $registerUserCommand->register($request->createDto());
        } catch (UserWithGivenEmailAlreadyExists $e) {
            return redirect()
                ->back()
                ->withErrors(['login' => trans('auth.login-already-taken')])
                ->withInput();
        }

        return redirect()->route('auth.login');
    }
}
