<?php

namespace App\Controller;

use App\Entity\Oeuvre;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ApiOeuvreController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/api/articles", name="api_articles_index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $oeuvre = $this->entityManager->getRepository(Oeuvre::class)->findAll();

        return $this->json($oeuvre, Response::HTTP_OK, [], ['groups' => 'oeuvre']);
    }

    /**
     * @Route("/api/articles/{id}", name="api_articles_show", methods={"GET"})
     */
    public function show(Oeuvre $oeuvre): JsonResponse
    {
        return $this->json($oeuvre, Response::HTTP_OK, [], ['groups' => 'oeuvre']);
    }
}
