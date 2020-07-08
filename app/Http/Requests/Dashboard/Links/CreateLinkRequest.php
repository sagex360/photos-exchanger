<?php

namespace App\Http\Requests\Dashboard\Links;

use App\DTO\FileLinks\CreateFileLinkDto;
use App\Http\Requests\AppFormRequest;
use App\Models\File;
use App\Rules\Groups\FileLink\LinkTypeRules;
use App\ValueObjects\LinkToken\LinkTokensFactory;

final class CreateLinkRequest extends AppFormRequest
{
    public function rules(LinkTypeRules $linkTypeRules): array
    {
        return [
            'link_type' => $linkTypeRules->get()
        ];
    }

    public function makeDto(File $file): CreateFileLinkDto
    {
        return new CreateFileLinkDto(
            $file,
            LinkTokensFactory::create(
                $this->input('link_type')
            )
        );
    }
}
