<?php

namespace App\Entity;

use App\Repository\PlateauBeignetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlateauBeignetRepository::class)]
class PlateauBeignet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: Beignet::class, inversedBy: 'plateauBeignets')]
    private $beignet;

    #[ORM\ManyToOne(targetEntity: Plateau::class, inversedBy: 'plateauBeignets')]
    private $plateau;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getBeignet(): ?Beignet
    {
        return $this->beignet;
    }

    public function setBeignet(?Beignet $beignet): self
    {
        $this->beignet = $beignet;

        return $this;
    }

    public function getPlateau(): ?Plateau
    {
        return $this->plateau;
    }

    public function setPlateau(?Plateau $plateau): self
    {
        $this->plateau = $plateau;

        return $this;
    }
}
