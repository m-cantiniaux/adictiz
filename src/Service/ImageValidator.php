<?php
    namespace App\Service;

    use Symfony\Component\HttpFoundation\File\UploadedFile;

    class ImageValidator
    {
        private array $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg'];

        public function isValid(UploadedFile $file): bool
        {
            return in_array($file->getMimeType(), $this->allowedMimeTypes);
        }
    }