<?php

namespace App\Controller;

use App\Entity\PageAccueil;
use App\Form\PageAccueilType;
use App\Repository\PageAccueilRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/accueil")
 */
class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="app_accueil_index", methods={"GET"})
     */
    public function index(PageAccueilRepository $pageAccueilRepository): Response
    {
        return $this->render('accueil/index.html.twig', [
            'page_accueils' => $pageAccueilRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_accueil_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PageAccueilRepository $pageAccueilRepository,EntityManagerInterface $manager): Response
    {
        $pageAccueil = new PageAccueil();
        $form = $this->createForm(PageAccueilType::class, $pageAccueil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile=$form->get('img1')->getData();
            if ($imageFile) {
                $nomImage = date("YmdHis") . "-" . uniqid() . "." . $imageFile->getClientOriginalExtension();
                $imageFile->move(
                    $this->getParameter("imageAcceuil"),
                    $nomImage
                );
                $pageAccueil->setImg1($nomImage);
                $pageAccueil->setImg2($nomImage);
                $pageAccueil->setImg3($nomImage);
            }
            $manager->persist($pageAccueil);
            $manager->flush();
            $pageAccueilRepository->add($pageAccueil, true);

            return $this->redirectToRoute('app_accueil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accueil/new.html.twig', [
            'page_accueil' => $pageAccueil,
            'form_accueil' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_accueil_show", methods={"GET"})
     */
    public function show(PageAccueil $pageAccueil): Response
    {
        return $this->render('accueil/show.html.twig', [
            'page_accueil' => $pageAccueil,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_accueil_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, PageAccueil $pageAccueil, PageAccueilRepository $pageAccueilRepository): Response
    {
        $form = $this->createForm(PageAccueilType::class, $pageAccueil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pageAccueilRepository->add($pageAccueil, true);

            return $this->redirectToRoute('app_accueil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accueil/edit.html.twig', [
            'page_accueil' => $pageAccueil,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_accueil_delete", methods={"POST"})
     */
    public function delete(Request $request, PageAccueil $pageAccueil, PageAccueilRepository $pageAccueilRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pageAccueil->getId(), $request->request->get('_token'))) {
            $pageAccueilRepository->remove($pageAccueil, true);
        }

        return $this->redirectToRoute('app_accueil_index', [], Response::HTTP_SEE_OTHER);
    }
}
