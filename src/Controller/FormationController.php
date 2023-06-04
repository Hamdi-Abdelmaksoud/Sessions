<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

 

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationController extends AbstractController
{
    #[Route('/formation', name: 'app_formation')]
    public function index(FormationRepository $formationRepository): Response
    {
        $formations = $formationRepository->findBy([], ["titre" => "ASC"]);
        return $this->render('formation/index.html.twig', [
            'formations' => $formations,
        ]);
    }
    #[Route('/formation/add', name: 'add_formation')]
    public function add(EntityManagerInterface $entityManager,Formation $formation=null,Request $request): Response
    {
        if(!$formation)
        {
            $formation=new Formation();
        }
        $form=$this->createForm(FormationType::class, $formation);//création du formulaire
         $form->handleRequest($request);//Inspecte la requete
         if ($form->isSubmitted() && $form->isValid()) 
        {
            $formation=$form->getData();//On récupère leq données
            $entityManager->persist($formation);//prepare on pdo
            $entityManager->flush();//excute
            return $this->redirectToRoute("app_formation");
        }

        // Add a default response here if the form is not submitted or not valid
        return $this->render('formation/add.html.twig', [
           'formAddFormations' => $form->createView(),
       ]);
    }
}
