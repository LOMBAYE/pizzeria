<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\Livraison;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\GestionnaireRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

#[ApiResource()]

#[ORM\Entity(repositoryClass: GestionnaireRepository::class)]
class Gestionnaire extends User
{
   
    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Produit::class)]
    private $produits;

    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Livraison::class)]
    private $livraisons;

    public function __construct()
    {   parent::__construct();
        $this->produits = new ArrayCollection();
        $this->livraisons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

  
    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setGestionnaire($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getGestionnaire() === $this) {
                $produit->setGestionnaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons[] = $livraison;
            $livraison->setGestionnaire($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getGestionnaire() === $this) {
                $livraison->setGestionnaire(null);
            }
        }

        return $this;
    }

 
}
