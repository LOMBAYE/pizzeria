<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LigneDeCommandeRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LigneDeCommandeRepository::class)]
class LigneDeCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["commande","client:read"])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["commande","client:read"])]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'ligneDeCommandes')]
    private $commande;

    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'ligneDeCommandes')]
    #[Groups(["commande","client:read"])]
    private $produit;

    #[ORM\Column(type: 'integer')]
    #[Groups(["commande","client:read"])]
    private $prix;

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

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
