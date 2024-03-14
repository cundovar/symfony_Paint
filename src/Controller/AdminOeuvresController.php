<?php

namespace App\Controller;

use App\Entity\Oeuvre;
use App\Form\OeuvreType;
use App\Repository\OeuvreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin/oeuvre")
 */
class AdminOeuvresController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_oeuvres")
     */
    public function index(OeuvreRepository $oeuvreRepository): Response
    {
        return $this->render('admin_oeuvres/index.html.twig', [
            'oeuvres' => $oeuvreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $oeuvre = new Oeuvre();
        $form = $this->createForm(OeuvreType::class, $oeuvre, [
            'ajouter' => true
        ]);

        $form->handleRequest($request);
     
        if ($form->isSubmitted() && $form->isValid()) {

          

          

            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $nomImage = date("YmdHis") . "-" . uniqid() . "." . $imageFile->getClientOriginalExtension();
                $imageFile->move(
                    $this->getParameter("imageOeuvre"),
                    $nomImage
                );
                $oeuvre->setImage($nomImage);
            }
            $manager->persist($oeuvre);
            $manager->flush();
            $this->addFlash("success", "Le produit N°" .  $oeuvre->getId()  .  " a bien été ajouté");
            return $this->redirectToRoute('app_admin_oeuvres', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_oeuvres/new.html.twig', [
            'oeuvre' => $oeuvre,
            'form' => $form,
        ]);

    }
    /**
     * @Route("/{id}/edit", name="app_admin_edit")
     */
     
    public function edit( Oeuvre $oeuvre, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(OeuvreType::class, $oeuvre, [
            'modifier' => true
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        

        

            $imageFile = $form->get('imageUpdate')->getData();
            if ($imageFile) {
                $nomImage = date("YmdHis") . "-" . uniqid() . "." . $imageFile->getClientOriginalExtension();

                $imageFile->move(
                    $this->getParameter("imageOeuvre"),
                    $nomImage
                );
                if ($oeuvre->getImage()) {

                    unlink($this->getParameter("imageOeuvre") . "/" . $oeuvre->getImage());
                }
                $oeuvre->setImage($nomImage);
            }




            $manager->persist($oeuvre);
            $manager->flush();
            $this->addFlash("success", "Le produit N°" . $oeuvre->getId() . " a bien été modifié");
            return $this->redirectToRoute('app_admin_oeuvres', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_oeuvres/edit.html.twig', [
            'oeuvre' => $oeuvre,
            'formEdit' => $form,

        ]);

    }
}
