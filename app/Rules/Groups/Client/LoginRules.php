<?php


namespace App\Rules\Groups\Client;


use App\Rules\Groups\RulesGroup;

final class LoginRules extends RulesGroup
{
    protected function rules(): array
    {
        return [
            'required',
            'email',
        ];
    }
}
