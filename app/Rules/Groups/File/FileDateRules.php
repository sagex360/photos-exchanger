<?php


namespace App\Rules\Groups\File;


use App\Rules\Groups\RulesGroup;

final class FileDateRules extends RulesGroup
{
    public const DATE_FORMAT = 'Y-m-d';

    protected function rules(): array
    {
        return [
            'nullable',
            'date_format:' . self::DATE_FORMAT,
            'after:now'
        ];
    }
}
