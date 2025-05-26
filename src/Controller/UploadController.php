<?php
    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Filesystem\Filesystem;
    use League\Flysystem\FilesystemOperator;
    use App\Form\UploadForm;
    use App\Entity\Image;
    use Doctrine\ORM\EntityManagerInterface;

    class UploadController extends AbstractController {
        public function upload(Request $request, FilesystemOperator $storage, EntityManagerInterface $em): Response {
            $form = $this->createForm(UploadForm::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                /** @var UploadedFile[] $files */
                $files = $form->get('images')->getData();

                foreach ($files as $file) {
                    $filename = uniqid() . '.' . $file->guessExtension();
                    $stream = fopen($file->getRealPath(), 'r');

                    $storage->writeStream($filename, $stream);
                    fclose($stream);

                    $image = new Image();
                    $image->setFilename($filename);
                    $image->setUrl('https://' . $_ENV['AWS_S3_BUCKET'] . '.s3.amazonaws.com/' . $filename);
                    $em->persist($image);
                }

                $em->flush();
                $this->addFlash('success', 'Images uploadées avec succès !');

                return $this->redirectToRoute('upload_image');
            }

            return $this->render('upload.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }
