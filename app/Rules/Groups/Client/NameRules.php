<?php


namespace App\Rules\Groups\Client;


use App\Rules\Groups\RulesGroup;
use App\ValueObjects\Name;

final class NameRules extends RulesGroup
{
    protected function rules()
    {
        return [
            'required',
            'string',
            'min:' . Name::MIN_LENGTH,
        ];
    }
}
