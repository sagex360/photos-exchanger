<?php


namespace App\Rules\Groups\File;


use App\Rules\Groups\RulesGroup;

class FileDateRules extends RulesGroup
{
    const DATE_FORMAT = 'Y-m-d';

    protected function rules()
    {
        return [
            'required',
            'date_format:' . self::DATE_FORMAT,
            'after:now'
        ];
    }
}
