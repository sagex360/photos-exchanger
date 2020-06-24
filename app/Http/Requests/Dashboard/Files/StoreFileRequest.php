<?php

declare(strict_types=1);

namespace App\Http\Requests\Dashboard\Files;

use App\DTO\Files\CreateFileDto;
use App\Http\Requests\AppFormRequest;
use App\Rules\Groups\File\FileDateRules;
use App\Rules\Groups\File\FileDescriptionRules;
use App\Rules\Groups\File\FileImageRules;
use App\Rules\Groups\File\FilePublicNameRules;
use App\ValueObjects\DeletionDate\DeletionDateFactory;
use App\ValueObjects\FileDescription;
use Illuminate\Support\Facades\Auth;

final class StoreFileRequest extends AppFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @param FileImageRules       $imageRules
     * @param FilePublicNameRules  $nameRules
     * @param FileDescriptionRules $descriptionRules
     * @param FileDateRules        $dateRules
     * @return array
     */
    public function rules(FileImageRules $imageRules,
                          FilePublicNameRules $nameRules,
                          FileDescriptionRules $descriptionRules,
                          FileDateRules $dateRules)
    {
        return [
            'public_name'    => $nameRules->get(),
            'description'    => $descriptionRules->get(),
            'date_to_delete' => $dateRules->get(),
            'file'           => $imageRules->get(),
        ];
    }

    /**
     * @return CreateFileDto
     */
    public function createDto()
    {
        return new CreateFileDto(
            Auth::id(),
            $this->file('file'),
            FileDescription::create(
                (string)$this->input('public_name'),
                (string)$this->input('description')
            ),
            DeletionDateFactory::fromFormat(
                FileDateRules::DATE_FORMAT,
                $this->input('date_to_delete')
            )
        );
    }
}
