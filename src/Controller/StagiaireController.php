<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use App\Repository\StagiaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StagiaireController extends AbstractController
{



#[Route('stagiaire/add', name: 'add_stagiaire')]
#[Route('/stagiaire/{id}/edit', name: 'edit_stagiaire')]
public function add(EntityManagerInterface $entityManager, Stagiaire $stagiaire = null, Request $request): Response{
    
    /* Si le stagiaire n'existe pas, on le crée */
    if(!$stagiaire){
        $stagiaire = new Stagiaire();
    }
    
    $form = $this->createForm(StagiaireType::class, $stagiaire); // On crée le formulaire
    $form->handleRequest($request); // Inspecte la requête
    if($form->isSubmitted() && $form->isValid()){
        $stagiaire = $form->getData(); // On récupère les données
        $entityManager->persist($stagiaire); // Équivalent du prepare
        $entityManager->flush(); // Équivalent du execute

        return $this->redirectToRoute("app_stagiaire");
    }

    return $this->render('stagiaire/add.html.twig', [
        'formAddStagiaire' => $form->createView(),
        'edit' => $stagiaire->getId()
    ]);
}
    #[Route('/stagiaire', name: 'app_stagiaire')]
    public function index(StagiaireRepository $stagiaireRepository): Response
    {
    $stagiaires=$stagiaireRepository->findBy([],["nom"=>"ASC"]);
        return $this->render('stagiaire/index.html.twig', [
            'stagiaires' => $stagiaires,
        ]);
    }
    #[Route('/stagiaire/{id}', name: 'show_stagiaire')]
    public function show(Stagiaire $stagiaire): Response
    
    {
     
        return $this->render('stagiaire/show.html.twig', [
            'stagiaire' => $stagiaire,
        ]);
    }
   
 
     
}
