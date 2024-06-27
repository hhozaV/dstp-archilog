<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProfesseurRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class ProfesseurController extends AbstractController
{
    #[Route('/professeur', name: 'app_professeur')]
    public function index(ProfesseurRepository $repository,
                          PaginatorInterface $paginator,
                          Request $request): Response
    {
        $professeurs = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
        );

        return $this->render('pages/professeur/index.html.twig', [
            'professeurs' => $professeurs,
        ]);
    }
}
