<?php


namespace App\Rules\Groups\FileLink;


use App\Rules\Groups\RulesGroup;
use App\ValueObjects\LinkToken\LinkTokensFactory;
use Illuminate\Validation\Rule;

final class LinkTypeRules extends RulesGroup
{
    protected function rules(): array
    {
        return [
            'required',
            'string',
            Rule::in(LinkTokensFactory::supportedTypes())
        ];
    }
}
