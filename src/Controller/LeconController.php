<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\LeconRepository;

class LeconController extends AbstractController
{
    #[Route('/lecon', name: 'app_lecon')]
    public function index(LeconRepository $repository): Response
    {

        $lecon = $repository->findAll();

        return $this->render('lecon/index.html.twig', [
            'controller_name' => 'LeconController',
        ]);
    }
}
