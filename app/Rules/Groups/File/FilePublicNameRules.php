<?php


namespace App\Rules\Groups\File;


use App\Rules\Groups\RulesGroup;

final class FilePublicNameRules extends RulesGroup
{
    const MAX_SIZE = 255;

    protected function rules(): array
    {
        return [
            'required',
            'string',
            'max:' . self::MAX_SIZE,
        ];
    }
}
