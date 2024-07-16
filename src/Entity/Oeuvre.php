<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OeuvreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * 
 * @ORM\Entity(repositoryClass=OeuvreRepository::class)
 *@ApiResource(
 *     collectionOperations={
 *         "get"={"normalization_context"={"groups"={"oeuvre:read"}}},
 *         "post"={"denormalization_context"={"groups"={"oeuvre:write"}}}
 *     },
 *     itemOperations={
 *         "get"={"normalization_context"={"groups"={"oeuvre:read"}}},
 *         "put"={"denormalization_context"={"groups"={"oeuvre:write"}}},
 *         "delete",
 *         "like"={
 *             "method"="POST",
 *             "path"="/oeuvres/{id}/like",
 *             "controller"=App\Controller\LikeOeuvreController::class,
 *             "swagger_context"={
 *                 "summary"="Adds a like to an Oeuvre",
 *                 "parameters"={
 *                     {
 *                         "name"="id",
 *                         "in"="path",
 *                         "required"=true,
 *                         "type"="integer",
 *                         "description"="The Oeuvre ID"
 *                     }
 *                 }
 *             },
 *             "input"=false,
 *             "output"=false
 *         },
 *         "unlike"={
 *             "method"="DELETE",
 *             "path"="/oeuvres/{id}/unlike",
 *             "controller"=App\Controller\UnlikeOeuvreController::class,
 *             "swagger_context"={
 *                 "summary"="Removes a like from an Oeuvre",
 *                 "parameters"={
 *                     {
 *                         "name"="id",
 *                         "in"="path",
 *                         "required"=true,
 *                         "type"="integer",
 *                         "description"="The Oeuvre ID"
 *                     }
 *                 }
 *             },
 *             "input"=false,
 *             "output"=false
 *         }
 *     }
 * )
 */
class Oeuvre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"oeuvre:read", "oeuvre:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"oeuvre:read", "oeuvre:write"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"oeuvre:read", "oeuvre:write"})
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="oeuvre")
     * @Groups({"oeuvre:read", "oeuvre:write"})
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"oeuvre:read", "oeuvre:write"})
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Theme::class, inversedBy="oeuvre")
     * @Groups({"oeuvre:read", "oeuvre:write"})
     */
    private $theme;

    /**
     * @ORM\OneToMany(targetEntity=Like::class, mappedBy="oeuvre")
     * @Groups({"oeuvre:read", "oeuvre:write"})
     */
    private $likes;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
    }

 
  
   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTheme(): ?Theme
    {
        return $this->theme;
    }

    public function setTheme(?Theme $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * @return Collection<int, Like>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setOeuvre($this);
        }

        return $this;
    }

    public function removeLike(Like $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getOeuvre() === $this) {
                $like->setOeuvre(null);
            }
        }

        return $this;
    }

  
   
}
