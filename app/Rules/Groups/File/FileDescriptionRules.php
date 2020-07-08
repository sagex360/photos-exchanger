<?php


namespace App\Rules\Groups\File;


use App\Rules\Groups\RulesGroup;
use App\ValueObjects\FileDescription;

final class FileDescriptionRules extends RulesGroup
{
    protected function rules(): array
    {
        return [
            'required',
            'string',
            'min:' . FileDescription::MIN_DESCRIPTION,
            'max:' . FileDescription::MAX_DESCRIPTION,
        ];
    }
}
