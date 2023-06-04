<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        $categories = $categorieRepository->findBy([], ["type" => "ASC"]);
        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
        ]);
    }
    #[Route('/categorie/add', name: 'add_categorie')]
    public function add(EntityManagerInterface $entityManager,Categorie $categorie=null,Request $request): Response
    {
        if(!$categorie)
        {
            $categorie=new Categorie();
        }
        $form=$this->createForm(CategorieType::class, $categorie);//création du formulaire
         $form->handleRequest($request);//Inspecte la requete
         if ($form->isSubmitted() && $form->isValid()) 
        {
            $categorie=$form->getData();//On récupère leq données
            $entityManager->persist($categorie);//prepare on pdo
            $entityManager->flush();//excute
            return $this->redirectToRoute("app_categorie");
        }

        // Add a default response here if the form is not submitted or not valid
        return $this->render('categorie/add.html.twig', [
           'formAddCategories' => $form->createView(),
       ]);
    }
}
