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
use App\Service\ImageUploader;

class ImagesController extends AbstractController{
    private FilesystemOperator $storage;
    private EntityManagerInterface $em;

    public function __construct(FilesystemOperator $storage, EntityManagerInterface $em) {
        $this->storage = $storage;
        $this->em = $em;
    }

    public function upload(Request $request, ImageUploader $uploader, LoggerInterface $logger): JsonResponse
    {
        $files = $request->files->get('images');

        if (!$files) {
            return $this->json(['error' => 'No files uploaded'], 400);
        }

        if (!is_iterable($files)) {
            $files = [$files];
        }

        $images = [];
        $uploaded = [];

        foreach ($files as $file) {
            $image = $uploader->upload($file);

            if ($image) {
                $images[] = $image;
            }
        }

        try {
            $this->em->flush();
        } catch (\Exception $e) {
            $logger->error('Doctrine flush failed', ['exception' => $e]);
            return $this->json(['error' => 'Could not save to database'], 500);
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
