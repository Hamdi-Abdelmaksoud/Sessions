<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Form\SessionType;

use App\Repository\ModuleRepository;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
 class SessionController extends AbstractController
{
   
    #[Route('session/add', name: 'add_session')]
#[Route('/session/{id}/edit', name: 'edit_session')]
public function add(EntityManagerInterface $entityManager, Session $session = null, Request $request): Response{
    
    /* Si session n'existe pas, on le crée */
    if(!$session){
        $session = new Session();
    }
    
    $form = $this->createForm(SessionType::class, $session); // On crée le formulaire
    $form->handleRequest($request); // Inspecte la requête
    if($form->isSubmitted() && $form->isValid()){
        $session = $form->getData(); // On récupère les données
        $entityManager->persist($session); // Équivalent du prepare
      
        $entityManager->flush(); // Équivalent du execute

        return $this->redirectToRoute("app_session");
    }

    return $this->render('session/add.html.twig', [
        'formAddSession' => $form->createView(),
        'edit' => $session->getId()
    ]);
}
    #[Route('/stagiaire/{id}/delete', name : 'delete_stagiaire')]
    public function delete(EntityManagerInterface $entityManager, Stagiaire $stagiaire = null): Response{
        $nomStagiaire = $stagiaire->getPrenom() . " " . $stagiaire->getNom();
        $entityManager->remove($stagiaire);
        $entityManager->flush();
        $this->addFlash('notice', 'Le stagiaire "' .  $nomStagiaire . '" a été supprimer');

        return $this->redirectToRoute("app_stagiaire");
    }
      
    #[Route('/session', name: 'app_session')]
    public function index(SessionRepository $sessionRepository): Response
    
    {
        $sessions=$sessionRepository->findBy([], ["titre" => "ASC"]);
        return $this->render('session/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }
    #[Route('/session/{id}', name: 'show_session')]
    public function show(Session $session): Response
    
    {
     
        return $this->render('session/show.html.twig', [
            'session' => $session,
        ]);
    }
    
  
}
