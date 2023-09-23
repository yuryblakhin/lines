<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Ramsey\Uuid\UuidInterface;

class FileUploadService
{
    /**
     * Загружает файл.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @return bool|string
     */
    public function upload(UploadedFile $file, $folder = 'uploads'): bool|string
    {
        $uuid = $this->generateUuid();
        $filename = $this->generateFilename($uuid, $file);
        $folderPath = $this->generateFolderPath($uuid, $folder);

        return $file->storeAs($folderPath, $filename, config('filesystems.default'));
    }

    /**
     * Генерирует новый UUID.
     *
     * @return UuidInterface
     */
    protected function generateUuid(): UuidInterface
    {
        return Str::uuid();
    }

    /**
     * Генерирует имя файла на основе UUID.
     *
     * @param UuidInterface $uuid
     * @param UploadedFile $file
     * @return string
     */
    protected function generateFilename(UuidInterface $uuid, UploadedFile $file): string
    {
        return $uuid->toString() . '.' . $file->getClientOriginalExtension();
    }

    /**
     * Генерирует путь к папке на основе UUID.
     *
     * @param UuidInterface $uuid
     * @param string $folder
     * @return string
     */
    protected function generateFolderPath(UuidInterface $uuid, string $folder): string
    {
        $hash = md5($uuid->toString());
        $firstLevel = substr($hash, 0, 2);
        $secondLevel = substr($hash, 2, 2);

        return $folder . '/' . $firstLevel . '/' . $secondLevel;
    }
}
