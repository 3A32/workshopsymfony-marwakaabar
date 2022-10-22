<?php

namespace App\Controller;
use App\Form\CategorieFormType;
use App\Entity\Categorie;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

    #[Route('/categories', name: 'app_categories')]
    public function listCategorie(CategorieRepository $repository){
        $categories=$repository->findAll();
        return $this->render("categorie/listCategorie.html.twig",array("tabCategorie"=>$categories));
    }

    #[Route('/addCategorie', name: 'app_addCategorie')]
    public function addCategorie(ManagerRegistry $doctrine,Request $request){
        $categorie=new Categorie();
        $form=$this->createForm(CategorieFormType::class,$categorie);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em= $doctrine->getManager();
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute("app_categories");
        }

        return $this->renderForm("categorie/addCategorie.html.twig",array("formCategorie"=>$form));
    }
}
