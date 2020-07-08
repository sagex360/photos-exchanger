<?php


namespace App\Http\Requests\Auth\Login;


use App\DTO\Auth\Login\LoginClientDto;
use App\Http\Requests\AppFormRequest;
use App\Rules\Groups\Client\LoginRules;
use App\Rules\Groups\Client\PasswordRules;

final class LoginClientRequest extends AppFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @param  LoginRules  $loginRules
     * @param  PasswordRules  $passwordRules
     * @return array
     */
    public function rules(LoginRules $loginRules, PasswordRules $passwordRules): array
    {
        return [
            'login'    => $loginRules->get(),
            'password' => $passwordRules->get(),
        ];
    }

    public function createDto(): LoginClientDto
    {
        return new LoginClientDto(
            $this->input('login'),
            $this->input('password'),
            $this->has('remember')
        );
    }
}
