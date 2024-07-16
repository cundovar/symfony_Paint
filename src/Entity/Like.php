<?php

namespace App\Entity;

use App\Repository\LikeRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ORM\Entity(repositoryClass=LikeRepository::class)
 *  @ApiResource(
 *     collectionOperations={
 *         "get"={"normalization_context"={"groups"={"like:read"}}},
 *         "post"={"denormalization_context"={"groups"={"like:write"}}}
 *     },
 *     itemOperations={
 *         "get"={"normalization_context"={"groups"={"like:read"}}},
 *         "put"={"denormalization_context"={"groups"={"like:write"}}},
 *         "delete"
 *     }
 * )
 */
class Like
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"like:read", "oeuvre:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $count;

    /**
     * @ORM\ManyToOne(targetEntity=Oeuvre::class, inversedBy="likes")
     * @Groups({"like:read", "like:write"})
     */
    private $oeuvre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ip;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(?int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getOeuvre(): ?Oeuvre
    {
        return $this->oeuvre;
    }

    public function setOeuvre(?Oeuvre $oeuvre): self
    {
        $this->oeuvre = $oeuvre;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }
}
