<?php

namespace App\Controller;

use App\Entity\PageAccueil;
use App\Form\PageAccueilType;
use App\Repository\PageAccueilRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
    public function new(Request $request,PageAccueil $pageAccueil, PageAccueilRepository $pageAccueilRepository,EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PageAccueilType::class, $pageAccueil, [
            'modifier' => true
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $images = [
                'img1' => 'setImg1',
                'img2' => 'setImg2',
                'img3' => 'setImg3',
            ];

            foreach ($images as $fieldName => $setter) {
                $imageFile = $form->get($fieldName)->getData();
                if ($imageFile instanceof UploadedFile) {
                    $nomImage = date("YmdHis") . "-" . uniqid() . "." . $imageFile->getClientOriginalExtension();
                    $imageFile->move(
                        $this->getParameter("imageAcceuil"),
                        $nomImage
                    );

                    // Supprimer l'ancienne image si elle existe
                    $getter = 'get' . ucfirst($fieldName);
                    if ($pageAccueil->{$getter}() && file_exists($this->getParameter('imageAcceuil') . '/' . $pageAccueil->{$getter}())) {
                        unlink($this->getParameter('imageAcceuil') . '/' . $pageAccueil->{$getter}());
                    }

                    // Appel dynamique au setter correspondant avec le nom de l'image
                    $pageAccueil->{$setter}($nomImage);
                }
            }

            $entityManager->flush();

            $this->addFlash("success", "La page d'accueil a bien été modifiée");
            return $this->redirectToRoute('app_accueil_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('accueil/new.html.twig', [
            'page_accueil' => $pageAccueil,
            'form' => $form,
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
    public function edit(Request $request, PageAccueil $pageAccueil, PageAccueilRepository $pageAccueilRepository,EntityManagerInterface $manager ): Response
    {
        $imagesAc = [
            'img1' => $pageAccueil->getImg1(),
            'img2' => $pageAccueil->getImg2(),
            'img3' => $pageAccueil->getImg3(),
        ];

        // Créer le formulaire en préremplissant les champs avec les noms des images existantes
        $form = $this->createForm(PageAccueilType::class, $pageAccueil, [
            'modifier' => true,
            'images' => $imagesAc, // Passer les noms des images existantes au formulaire
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
         
            $images = [
                'img1' => 'setImg1',
                'img2' => 'setImg2',
                'img3' => 'setImg3',
                'img4' => 'setImg4',
                'img5' => 'setImg5',
            ];

            foreach($images as $fieldName=>$setter){
                $imageFile=$form->get($fieldName)->getData();
              if(  $imageFile instanceof UploadedFile){
                $nomImage=date("YmdHis") . "-" . uniqid() . "." . $imageFile->getClientOriginalExtension();
                $imageFile->move(
                    $this->getParameter("imageAcceuil"),$nomImage
                );
                $pageAccueil->{$setter}($nomImage);

              }
            }
            $manager->flush();



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
    public function delete(Request $request, PageAccueil $pageAccueil, PageAccueilRepository $pageAccueilRepository,EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pageAccueil->getId(), $request->request->get('_token'))) {

            $manager->getConnection()
            ->beginTransaction();
            try{

                $pageAccueilRepository->remove($pageAccueil, true);
                
                // Supprimer l'image associée si elle existe
                $image=[
                    $pageAccueil->getImg1(),
                    $pageAccueil->getImg2(),
                    $pageAccueil->getImg3(),
                    $pageAccueil->getImg4(),
                    $pageAccueil->getImg5(),
                ];

                foreach($image as $imageName){
                    $imagePath = $this->getParameter('imageAcceuil') . '/' . $imageName;
                    if (file_exists($imagePath) && is_file($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $manager->commit();
               
            } catch (\Exception $e) {
                $manager->getConnection()->rollBack();
                throw $e;
            }
            }


        

        return $this->redirectToRoute('app_accueil_index', [], Response::HTTP_SEE_OTHER);
    }
}
