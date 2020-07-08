<?php


namespace App\Rules\Groups\File;


use App\Rules\Groups\RulesGroup;

final class FileImageRules extends RulesGroup
{
    public const MAX_SIZE = 1024 * 5;

    protected function rules(): array
    {
        return [
            'required',
            'file',
            'image',
            'max:' . self::MAX_SIZE
        ];
    }
}
