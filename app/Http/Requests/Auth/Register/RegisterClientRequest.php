<?php

namespace App\Http\Requests\Auth\Register;

use App\DTO\Auth\Register\RegisterClientDto;
use App\Http\Requests\AppFormRequest;
use App\Rules\Groups\Client\LoginRules;
use App\Rules\Groups\Client\NameRules;
use App\Rules\Groups\Client\PasswordRules;

final class RegisterClientRequest extends AppFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @param NameRules     $nameRules
     * @param LoginRules    $loginRules
     * @param PasswordRules $passwordRules
     * @return array
     */
    public function rules(NameRules $nameRules, LoginRules $loginRules, PasswordRules $passwordRules): array
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
