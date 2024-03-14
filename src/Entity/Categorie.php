<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Oeuvre::class, mappedBy="categorie")
     */
    private $oeuvre;

    public function __construct()
    {
        $this->oeuvre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Oeuvre>
     */
    public function getOeuvre(): Collection
    {
        return $this->oeuvre;
    }

    public function addOeuvre(Oeuvre $oeuvre): self
    {
        if (!$this->oeuvre->contains($oeuvre)) {
            $this->oeuvre[] = $oeuvre;
            $oeuvre->setCategorie($this);
        }

        return $this;
    }

    public function removeOeuvre(Oeuvre $oeuvre): self
    {
        if ($this->oeuvre->removeElement($oeuvre)) {
            // set the owning side to null (unless already changed)
            if ($oeuvre->getCategorie() === $this) {
                $oeuvre->setCategorie(null);
            }
        }

        return $this;
    }
}
