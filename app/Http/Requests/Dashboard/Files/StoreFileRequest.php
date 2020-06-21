<?php

namespace App\Http\Requests\Dashboard\Files;

use App\Http\Requests\AppFormRequest;
use App\Rules\Groups\File\FileDateRules;
use App\Rules\Groups\File\FileDescriptionRules;
use App\Rules\Groups\File\FileImageRules;

final class StoreFileRequest extends AppFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @param FileImageRules $imageRules
     * @param FileDescriptionRules $descriptionRules
     * @param FileDateRules $dateRules
     * @return array
     */
    public function rules(FileImageRules $imageRules, FileDescriptionRules $descriptionRules, FileDateRules $dateRules)
    {
        return [
            'description' => $descriptionRules->get(),
            'date_to_delete' => $dateRules->get(),
            'file' => $imageRules->get(),
        ];
    }
}
