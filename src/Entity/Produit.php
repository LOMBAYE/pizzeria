<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ApiResource(
    collectionOperations:[
        "GET"=>[
            'method' => 'get',
            'normalization_context' => ['groups' => ['simple']]
        ]
        ],
        itemOperations:[
            "get"=>[
            'method' => 'get',
            "path"=>"/produits/{id}" ,
            'requirements' => ['id' => '\d+'],
            'normalization_context' => ['groups' => ['all']],
            ],
            "delete"=>[
                "path"=>"/produits/{id}" 
            ]
            ]
)]

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ORM\Table(name:'`produit`')]


#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"type", type:"string")]
#[ORM\DiscriminatorMap(["burger"=>"Burger", "menu"=>"Menu", "boissons"=>"BoissonTaille","frites"=>"FritesPortion"])]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(["menu:simple"])]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[Assert\NotBlank(message:"Le nom est Obligatoire")]
    #[Groups(["all"])]
    #[ORM\Column(type: 'string', length: 255)]
    protected $nom;

    #[Groups([ "all"])]
    #[ORM\Column(type: 'integer')]
    protected $prix;

    #[ORM\Column(type: 'blob')]
    protected $image;

    #[Groups([ "all"])]
    #[SerializedName("image")]
    protected $bImage;

    #[ORM\Column(type: 'boolean')]
    protected $isEtat=true;

    #[Groups(["all"])]
    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    protected $gestionnaire;

    // #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'produits')]
    // private $commandes;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: LigneDeCommande::class)]
    private $ligneDeCommandes;

    public function __construct()
    {
        $this->ligneDeCommandes = new ArrayCollection();
        // $this->commandes = new ArrayCollection();
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

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function isIsEtat(): ?bool
    {
        return $this->isEtat;
    }

    public function setIsEtat(bool $isEtat): self
    {
        $this->isEtat = $isEtat;

        return $this;
    }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    /**
     * @return Collection<int, LigneDeCommande>
     */
    public function getLigneDeCommandes(): Collection
    {
        return $this->ligneDeCommandes;
    }

    public function addLigneDeCommande(LigneDeCommande $ligneDeCommande): self
    {
        if (!$this->ligneDeCommandes->contains($ligneDeCommande)) {
            $this->ligneDeCommandes[] = $ligneDeCommande;
            $ligneDeCommande->setProduit($this);
        }

        return $this;
    }

    public function removeLigneDeCommande(LigneDeCommande $ligneDeCommande): self
    {
        if ($this->ligneDeCommandes->removeElement($ligneDeCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneDeCommande->getProduit() === $this) {
                $ligneDeCommande->setProduit(null);
            }
        }

        return $this;
    }

    // /**
    //  * @return Collection<int, Commande>
    //  */
    // public function getCommandes(): Collection
    // {
    //     return $this->commandes;
    // }

    // public function addCommande(Commande $commande): self
    // {
    //     if (!$this->commandes->contains($commande)) {
    //         $this->commandes[] = $commande;
    //         $commande->addProduit($this);
    //     }

    //     return $this;
    // }

    // public function removeCommande(Commande $commande): self
    // {
    //     if ($this->commandes->removeElement($commande)) {
    //         $commande->removeProduit($this);
    //     }

    //     return $this;
    // }

 


    /**
     * Get the value of bImage
     */ 
    public function getBImage()
    {
        return $this->bImage;
    }

    /**
     * Set the value of bImage
     *
     * @return  self
     */ 
    public function setBImage($bImage)
    {
        $this->bImage = $bImage;

        return $this;
    }
}
