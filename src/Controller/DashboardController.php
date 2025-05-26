<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

class DashboardController extends AbstractController {
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function index(Request $request, PaginatorInterface $paginator): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $queryBuilder = $this->em->getRepository(Image::class)->createQueryBuilder('i');
        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1), 
            10 
        );

        return $this->render('dashboard.html.twig', [
            'images' => $pagination,
        ]);
    }
}
