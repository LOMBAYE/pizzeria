<?php

namespace App\Entity;

use App\Repository\BeignetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BeignetRepository::class)]
class Beignet
{
    // Classe creee pour s entrainer avec les controleurs personnalises(entite hors
    // du projet,Plateau)
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'integer')]
    private $prix;

    #[ORM\OneToMany(mappedBy: 'beignet', targetEntity: PlateauBeignet::class)]
    private $plateauBeignets;

    public function __construct()
    {
        $this->plateauBeignets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection<int, PlateauBeignet>
     */
    public function getPlateauBeignets(): Collection
    {
        return $this->plateauBeignets;
    }

    public function addPlateauBeignet(PlateauBeignet $plateauBeignet): self
    {
        if (!$this->plateauBeignets->contains($plateauBeignet)) {
            $this->plateauBeignets[] = $plateauBeignet;
            $plateauBeignet->setBeignet($this);
        }

        return $this;
    }

    public function removePlateauBeignet(PlateauBeignet $plateauBeignet): self
    {
        if ($this->plateauBeignets->removeElement($plateauBeignet)) {
            // set the owning side to null (unless already changed)
            if ($plateauBeignet->getBeignet() === $this) {
                $plateauBeignet->setBeignet(null);
            }
        }

        return $this;
    }
}
