<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;
use App\Form\UploadForm;

class UploadController extends AbstractController{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client){
    
        $this->client = $client;
    }
    
    public function upload(Request $request): Response{
    
        $form = $this->createForm(UploadForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $form->get('images')->getData();

            $formData = [];
            foreach ($files as $file) {
                $formData['images'][] = DataPart::fromPath(
                    $file->getPathname(),
                    $file->getClientOriginalName()
                );
            }

            $formDataPart = new FormDataPart($formData);

            try {
                $response = $this->client->request('POST', $this->generateUrl('api_images_upload', [], 0), [
                    'headers' => $formDataPart->getPreparedHeaders()->toArray(),
                    'body' => $formDataPart->bodyToIterable(),
                ]);

                if ($response->getStatusCode() !== 201) {
                    $this->addFlash('error', 'Erreur lors de l\'upload via API');
                } else {
                    $this->addFlash('success', 'Images uploadées avec succès via API !');
                }
            } catch (\Exception $e) {
                $this->addFlash('error', 'Exception lors de l\'appel API : ' . $e->getMessage());
            }

            return $this->redirectToRoute('home');
        }

        return $this->render('upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
