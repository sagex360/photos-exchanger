<?php


namespace App\Services\LinkTokens;


use App\DTO\FileLinks\CreateFileLinkDto;
use App\Exceptions\CouldNotSaveLinkTokenException;
use App\Models\FileLinkToken;

final class CreateLinkCommand
{
    /**
     * @param  CreateFileLinkDto  $dto
     * @return FileLinkToken
     * @throws CouldNotSaveLinkTokenException
     */
    public function execute(CreateFileLinkDto $dto): FileLinkToken
    {
        $linkToken = new FileLinkToken();

        $linkToken->token = $dto->getToken();
        $linkToken->file_id = $dto->getFile()->id;

        if ($linkToken->save()) {
            return $linkToken;
        }

        throw new CouldNotSaveLinkTokenException(trans('texts.dashboard.file-links.errors.create'));
    }
}
