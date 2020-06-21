<?php


namespace App\Rules\Groups\File;


use App\Rules\Groups\RulesGroup;

class FileImageRules extends RulesGroup
{
    const MAX_SIZE = 1024 * 5;

    protected function rules()
    {
        return [
            'required',
            'file',
            'image',
            'max:' . self::MAX_SIZE
        ];
    }
}
