<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProfesseurRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Professeur;
use App\Form\ProfesseurType;
use Doctrine\ORM\EntityManagerInterface;

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

    #[Route('/professeur/nouveau', 'professeur_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ): Response
    {
        $professeur = new Professeur();
        $form = $this->createForm(ProfesseurType::class, $professeur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $professeur = $form->getData();

            $manager->persist($professeur);
            $manager->flush();

            $this->addFlash(
                'success',
                'Vos changements ont été enregistrés !'
            );

            return $this->redirectToRoute('app_professeur');
        }

        return $this->render('pages/professeur/new.html.twig', [
            'form' => $form,
    ]);
    }

    #[Route('/professeur/edit/{name}','professeur_edit',methods:['GET','POST'])]
    public function edit(
        Request $request,
        EntityManagerInterface $manager,
        Professeur $professeur
    ): Response
    {
        $form = $this->createForm(ProfesseurTyoe::class, $professeur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $professeur = $form->getData();

            // $manager->persist($professeur);
            $manager->flush();

            $this->addFlash(
                'success',
                'Vos changements ont été enregistrés !'
            );

            return $this->redirectToRoute('app_professeur');
        }

        return $this->render('pages/professeur/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('professeur/remove/{id}','professeur_remove', methods:['GET','POST'])]
    public function remove(
        Request $request,
        EntityManagerInterface $manager,
        Professeur $professeur
    ): Response
    {
        $manager->remove($professeur);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le professeur a été supprimé"
        );
        return $this->redirectToRoute('app_professeur');
    }

}
