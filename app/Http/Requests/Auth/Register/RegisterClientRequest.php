<?php

namespace App\Http\Requests\Auth\Register;

use App\DTO\Auth\Register\RegisterClientDto;
use App\Http\Requests\AppFormRequest;
use App\Rules\Groups\Client\LoginRules;
use App\Rules\Groups\Client\NameRules;
use App\Rules\Groups\Client\PasswordRules;

class RegisterClientRequest extends AppFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @param NameRules $nameRules
     * @param \App\Rules\Groups\Client\LoginRules $loginRules
     * @param \App\Rules\Groups\Client\PasswordRules $passwordRules
     * @return array
     */
    public function rules(NameRules $nameRules, LoginRules $loginRules, PasswordRules $passwordRules)
    {
        return [
            'name'  => $nameRules->get(),
            'login' => $loginRules->get(),

            'password'              => $passwordRules->merge(['confirmed'])->get(),
            'password_confirmation' => $passwordRules->get()
        ];
    }

    public function createDto(): RegisterClientDto
    {
        return new RegisterClientDto(
            $this->input('name'),
            $this->input('login'),
            $this->input('password')
        );
    }
}
