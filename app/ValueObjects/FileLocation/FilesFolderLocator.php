<?php


namespace App\ValueObjects\FileLocation;


use InvalidArgumentException;

/**
 * Class FilesFolderLocator
 * @package App\ValueObjects\FileLocation
 * @internal
 */
final class FilesFolderLocator
{
    /**
     * @param  string  $disk
     * @return InvalidArgumentException
     */
    protected function invalidDiskType(string $disk): InvalidArgumentException
    {
        return new InvalidArgumentException("Unknown disk type: '$disk'");
    }

    public function locate(string $disk): string
    {
        if ($disk === 'public') {
            return 'uploads/files';
        }

        throw $this->invalidDiskType($disk);
    }

    public function link(string $disk, string $fullPath): string
    {
        if ($disk === 'public') {
            return config('filesystems.disks.public.url')."/$fullPath";
        }

        throw $this->invalidDiskType($disk);
    }
}
