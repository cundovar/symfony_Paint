<?php 

namespace App\Controller;

use App\Entity\Oeuvre;
use App\Entity\Like;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class LikeOeuvreController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(Oeuvre $data): JsonResponse
    {
        $like = new Like();
        $like->setOeuvre($data);

        $this->entityManager->persist($like);
        $this->entityManager->flush();

        return new JsonResponse(['id' => $like->getId(), 'message' => 'Oeuvre liked']);
    }
}
