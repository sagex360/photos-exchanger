<?php


namespace App\Rules\Groups\File;


use App\Rules\Groups\RulesGroup;
use App\ValueObjects\FileDescription;

final class FilePublicNameRules extends RulesGroup
{
    protected function rules(): array
    {
        return [
            'required',
            'string',
            'min:' . FileDescription::MIN_PUBLIC_NAME,
            'max:' . FileDescription::MAX_PUBLIC_NAME,
        ];
    }
}
