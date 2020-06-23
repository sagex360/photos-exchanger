<?php

namespace App\Http\Requests\Dashboard\Files;

use App\DTO\Files\CreateFileDto;
use App\Http\Requests\AppFormRequest;
use App\Rules\Groups\File\FileDateRules;
use App\Rules\Groups\File\FileDescriptionRules;
use App\Rules\Groups\File\FileImageRules;
use App\ValueObjects\DeletionDate\DeletionDateFactory;
use App\ValueObjects\FileDescription;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Auth;

final class StoreFileRequest extends AppFormRequest
{
    protected function passedValidation()
    {
        $this->merge([
            'description' => "{$this->input('description')}"
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param FileImageRules       $imageRules
     * @param FileDescriptionRules $descriptionRules
     * @param FileDateRules        $dateRules
     * @return array
     */
    public function rules(FileImageRules $imageRules, FileDescriptionRules $descriptionRules, FileDateRules $dateRules)
    {
        return [
            'description'    => $descriptionRules->get(),
            'date_to_delete' => $dateRules->get(),
            'file'           => $imageRules->get(),
        ];
    }

    /**
     * @return CreateFileDto
     * @throws BindingResolutionException
     */
    public function createDto()
    {
        $dateFactory = $this->container->make(DeletionDateFactory::class);

        return new CreateFileDto(
            Auth::id(),
            $this->file('file'),
            $dateFactory->fromFormat(FileDateRules::DATE_FORMAT, $this->input('date_to_delete')),
            FileDescription::create((string)$this->input('description'))
        );
    }
}
