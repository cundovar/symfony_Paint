<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin/categorie")
 */
class AdminCategorieController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_categorie")
     */
    public function index(CategorieRepository $cetagorieRepo): Response
    {
        return $this->render('admin_categorie/index.html.twig', [
            'categorie'=>$cetagorieRepo->findAll()
        ]);
    }

     /**
     * @Route("/new", name="app_admin_categorie_new")
     */
    public function new(Request $request,CategorieRepository $categorieRepo):Response
    {
        $categorie=new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categorieRepo->add($categorie, true);
            return $this->redirectToRoute('app_admin_oeuvres', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin_categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }
}
