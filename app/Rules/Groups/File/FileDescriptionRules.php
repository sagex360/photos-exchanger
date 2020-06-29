<?php


namespace App\Rules\Groups\File;


use App\Rules\Groups\RulesGroup;

class FileDescriptionRules extends RulesGroup
{
    const MAX_SIZE = 65534;

    protected function rules(): array
    {
        return [
            'required',
            'string',
            'max:' . self::MAX_SIZE,
        ];
    }
}
