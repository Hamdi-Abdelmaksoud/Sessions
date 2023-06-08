<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Repository\ModuleRepository;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

 class SessionController extends AbstractController
{
   
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
