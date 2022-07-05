<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ApiResource(
    collectionOperations:[
        "GET"=>[
            'normalization_context' => ['groups' => ['commande']],
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message"=>"Vous n'avez pas acces à cette Ressource",
        ],
        "POST"=>[
            'normalization_context' => ['groups' => ['read:simple']],
            'denormalization_context' => ['groups' => ['simple']],
            "security" => "is_granted('ROLE_CLIENT')",
            "security_message"=>"Vous n'avez pas acces à cette Ressource",
        ],
        ],
)]

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    
    #[ORM\Column(type: 'boolean', nullable: true)]
    private $isEtat=true;

    #[ORM\Column(type: 'string', nullable: true)]
    private $numero;

    #[Groups(["commande"])]
    #[ORM\Column(type: 'date', nullable: true)]
    private $date;

    #[Groups(["commande"])]
    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    private $client;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: LigneDeCommande::class,cascade:['persist'])]
    #[Groups(["simple","read:simple"])]
    #[SerializedName("Produits")]
    private $ligneDeCommandes;

    // #[Groups(["commande"])]
    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    private $livraison;


    public function __construct()
    {
        $this->ligneDeCommandes = new ArrayCollection();
        $this->date=new \DateTime();
    }

    public function isIsEtat(): ?bool
    {
        return $this->isEtat;
    }

    public function setIsEtat(?bool $isEtat): self
    {
        $this->isEtat = $isEtat;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(?int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    // ajoute ? pour dire qu il peut etre nul
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
            $ligneDeCommande->setCommande($this);
        }

        return $this;
    }

    public function removeLigneDeCommande(LigneDeCommande $ligneDeCommande): self
    {
        if ($this->ligneDeCommandes->removeElement($ligneDeCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneDeCommande->getCommande() === $this) {
                $ligneDeCommande->setCommande(null);
            }
        }

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }

    // /**
    //  * @return Collection<int, Produit>
    //  */
    // public function getProduits(): Collection
    // {
    //     return $this->produits;
    // }

    // public function addProduit(Produit $produit): self
    // {
    //     if (!$this->produits->contains($produit)) {
    //         $this->produits[] = $produit;
    //     }

    //     return $this;
    // }

    // public function removeProduit(Produit $produit): self
    // {
    //     $this->produits->removeElement($produit);

    //     return $this;
    // }
}
