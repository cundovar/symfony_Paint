<?php
// src/Controller/LikeController.php

namespace App\Controller;

use App\Entity\Oeuvre;
use App\Entity\Like;
use App\Service\LikeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;

class LikeController extends AbstractController
{
    private $likeService;
    private $security;

    public function __construct(LikeService $likeService, Security $security)
    {
        $this->likeService = $likeService;
        $this->security = $security;
    }

    /**
     * @Route("/oeuvres/{id}/like", name="like_oeuvre", methods={"POST"})
     */
    public function likeOeuvre(Oeuvre $oeuvre): JsonResponse
    {
        $user = $this->security->getUser();
        if (!$user) {
            return new JsonResponse(['message' => 'User not authenticated'], 401);
        }

        $like = $this->likeService->addLike($oeuvre, $user);

        return new JsonResponse(['id' => $like->getId(), 'message' => 'Oeuvre liked']);
    }

    /**
     * @Route("/likes/{id}/unlike", name="unlike_oeuvre", methods={"DELETE"})
     */
    public function unlikeOeuvre(Like $like): JsonResponse
    {
        $user = $this->security->getUser();
        if (!$user || $like->getIp() !== $user) {
            return new JsonResponse(['message' => 'Unauthorized'], 403);
        }

        $this->likeService->removeLike($like);

        return new JsonResponse(['message' => 'Like removed']);
    }
}
