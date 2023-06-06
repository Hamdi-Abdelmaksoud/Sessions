<?php

namespace App\Controller;

use App\Entity\Programme;
use App\Form\ProgrammeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
 
 
 
 


class ProgrammeController extends AbstractController
{
    #[Route('/programme', name: 'app_programme')]
    public function index(): Response
    {
        return $this->render('programme/index.html.twig', [
            'controller_name' => 'ProgrammeController',
        ]);
    }
    
   
   
    #[Route('/programme/add', name: 'add_programme')]
    public function add(EntityManagerInterface $entityManager, Programme $programme = null, Request $request): Response
    {
        if (!$programme) {
            $programme = new Programme();
        }
        $form = $this->createForm(ProgrammeType::class, $programme); //création du formulaire
        $form->handleRequest($request); //Inspecte la requete
        if ($form->isSubmitted() && $form->isValid()) {
            $programme = $form->getData(); //On récupère leq données
            $entityManager->persist($programme); //prepare on pdo
            $entityManager->flush(); //excute
            return $this->redirectToRoute("app_session");
        }

        // Add a default response here if the form is not submitted or not valid
        return $this->render('programme/add.html.twig', [
            'formAddProgramme' => $form->createView(),
        ]);
    }
}
