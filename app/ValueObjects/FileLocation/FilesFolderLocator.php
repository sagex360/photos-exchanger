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
     * @param string $disk
     * @throws InvalidArgumentException
     */
    protected function invalidDiskType(string $disk)
    {
        throw new InvalidArgumentException("Unknown disk type: '$disk'");
    }

    public function locate(string $disk)
    {
        if ($disk === 'public') {
            return 'uploads/files';
        }

        $this->invalidDiskType($disk);
    }

    public function link(string $disk, string $fullPath)
    {
        if ($disk === 'public') {
            return config('filesystems.disks.public.url') . "/$fullPath";
        }

        $this->invalidDiskType($disk);
    }
}
