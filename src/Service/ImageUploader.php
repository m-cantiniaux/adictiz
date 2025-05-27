<?php

    namespace App\Service;

    use App\Entity\Image;
    use Doctrine\ORM\EntityManagerInterface;
    use League\Flysystem\FilesystemOperator;
    use Symfony\Component\HttpFoundation\File\UploadedFile;
    use App\Service\ImageValidator;

    class ImageUploader
    {
        public function __construct(
            private FilesystemOperator $storage,
            private EntityManagerInterface $em,
            private ImageValidator $validator
        ) {}

        public function upload(UploadedFile $file): ?Image
        {
            if (!$this->validator->isValid($file)) {
                return null;
            }

            $extension = $file->guessExtension() ?: $file->getClientOriginalExtension() ?: 'bin';
            $filename = uniqid('', true) . '.' . $extension;

            $stream = fopen($file->getPathname(), 'rb');
            if (!$stream) {
                return null;
            }

            $this->storage->writeStream($filename, $stream);
            if (is_resource($stream)) {
                fclose($stream);
            }

            $image = new Image();
            $image->setFilename($filename);
            $image->setUrl(sprintf(
                'https://%s.s3.%s.amazonaws.com/%s',
                $_ENV['AWS_BUCKET'],
                $_ENV['AWS_REGION'],
                $filename
            ));

            $this->em->persist($image);

            return $image;
        }
    }
