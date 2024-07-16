<?php
// src/Service/LikeService.php

namespace App\Service;


use App\Entity\Like;
use App\Entity\Oeuvre;
use App\Repository\LikeRepository;
use Doctrine\ORM\EntityManagerInterface;

class LikeService
{
    private $entityManager;
    private $likeRepository;

    public function __construct(EntityManagerInterface $entityManager, LikeRepository $likeRepository)
    {
        $this->entityManager = $entityManager;
        $this->likeRepository = $likeRepository;
    }

    public function addLike(Oeuvre $article, $ip): Like
    {
        $like = new Like();
        $like->setOeuvre($article);
        $like->setIp($ip);

        $this->entityManager->persist($like);
        $this->entityManager->flush();

        return $like;
    }

    public function removeLike(Like $like)
    {
        $this->entityManager->remove($like);
        $this->entityManager->flush();
    }
}
