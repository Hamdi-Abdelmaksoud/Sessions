<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\ModuleType;
use App\Repository\ModuleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModuleController extends AbstractController
{
    #[Route('/module', name: 'app_module')]
    public function index(ModuleRepository $moduleRepository): Response
    {
        $modules = $moduleRepository->findBy([], ["libelle" => "ASC"]);
        return $this->render('module/index.html.twig', [
            'modules' => $modules,
        ]);
    }
    #[Route('/module/add', name: 'add_module')]
    public function add(EntityManagerInterface $entityManager, Module $module = null, Request $request): Response
    {
        if (!$module) {
            $module = new Module();
        }
        $form = $this->createForm(ModuleType::class, $module); //création du formulaire
        $form->handleRequest($request); //Inspecte la requete
        if ($form->isSubmitted() && $form->isValid()) {
            $module = $form->getData(); //On récupère leq données
            $entityManager->persist($module); //prepare on pdo
            $entityManager->flush(); //excute
            return $this->redirectToRoute("app_module");
        }

        // Add a default response here if the form is not submitted or not valid
        return $this->render('module/add.html.twig', [
            'formAddModules' => $form->createView(),
        ]);
    }
}
