<?php

namespace App\Controller;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemOperator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

class ImagesController extends AbstractController{
    private FilesystemOperator $storage;
    private EntityManagerInterface $em;

    public function __construct(FilesystemOperator $storage, EntityManagerInterface $em) {
        $this->storage = $storage;
        $this->em = $em;
    }

    public function upload(Request $request, LoggerInterface $logger): JsonResponse {
        $files = $request->files->get('images');

        if (!$files) {
            return $this->json(['error' => 'No files uploaded'], 400);
        }

        if (!$files instanceof \Traversable && !is_array($files)) {
            $files = [$files];
        }

        $uploaded = [];
        $images = []; 

        foreach ($files as $file) {
            if (!is_object($file)) {
                continue;
            }

            $extension = $file->guessExtension() ?: $file->getClientOriginalExtension() ?: 'bin';
            $filename = uniqid('', true) . '.' . $extension;

            $stream = fopen($file->getPathname(), 'rb');
            if (!$stream) {
                continue;
            }

            $result = $this->storage->writeStream($filename, $stream);
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
            $images[] = $image; 
            
        }

        try {
            $this->em->flush();
        } catch (\Exception $e) {
            $logger->error('Doctrinesss flush failed', ['exception' => $e]);
        }

        foreach ($images as $image) {
            $uploaded[] = [
                'id' => $image->getId(),
                'filename' => $image->getFilename(),
                'url' => $image->getUrl(),
            ];
        }

        return $this->json(['uploaded' => $uploaded], 201);
    }
}
