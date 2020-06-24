<?php

declare(strict_types=1);

namespace App\Http\Requests\Dashboard\Files;


use App\DTO\Files\UpdateFileDto;
use App\Http\Requests\AppFormRequest;
use App\Rules\Groups\File\FileDateRules;
use App\Rules\Groups\File\FileDescriptionRules;
use App\Rules\Groups\File\FilePublicNameRules;
use App\ValueObjects\DeletionDate\DeletionDateFactory;
use App\ValueObjects\FileDescription;

final class UpdateFileRequest extends AppFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @param FilePublicNameRules  $nameRules
     * @param FileDescriptionRules $descriptionRules
     * @param FileDateRules        $dateRules
     * @return array
     */
    public function rules(FilePublicNameRules $nameRules,
                          FileDescriptionRules $descriptionRules,
                          FileDateRules $dateRules)
    {
        return [
            'public_name'    => $nameRules->get(),
            'description'    => $descriptionRules->get(),
            'date_to_delete' => $dateRules->get(),
        ];
    }

    /**
     * @param int $id
     * @return UpdateFileDto
     */
    public function createDto(int $id)
    {
        return new UpdateFileDto(
            $id,
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
