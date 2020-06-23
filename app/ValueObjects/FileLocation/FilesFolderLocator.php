<?php


namespace App\ValueObjects\FileLocation;


/**
 * Class FilesFolderLocator
 * @package App\ValueObjects\FileLocation
 * @internal
 */
final class FilesFolderLocator
{
    public function locate(string $disk)
    {
        if ($disk === 'local') {
            return 'uploads';
        }

        throw new \InvalidArgumentException("Unknown disk type: '$disk'");
    }
}
