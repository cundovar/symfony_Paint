<?php

namespace App\Controller;

use App\Entity\Oeuvre;
use App\Repository\LikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UnlikeOeuvreController extends AbstractController
{
    private $entityManager;
    private $likeRepository;

    public function __construct(EntityManagerInterface $entityManager, LikeRepository $likeRepository)
    {
        $this->entityManager = $entityManager;
        $this->likeRepository = $likeRepository;
    }

    public function __invoke(Oeuvre $data): JsonResponse
    {
        $like = $this->likeRepository->findOneBy(['oeuvre' => $data]);

        if ($like) {
            $this->entityManager->remove($like);
            $this->entityManager->flush();
        }

        return new JsonResponse(['message' => 'Like removed']);
    }
}
