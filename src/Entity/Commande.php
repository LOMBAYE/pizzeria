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
            // "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message"=>"Vous n'avez pas acces à cette Ressource",
        ],
        "POST"=>[
            // 'normalization_context' => ['groups' => ['read:simple']],
            'denormalization_context' => ['groups' => ['commande']],
            // "security" => "is_granted('ROLE_CLIENT')",
            "security_message"=>"Vous n'avez pas acces à cette Ressource",
        ],
        ],
        itemOperations:[
            'GET'=>[
                'normalization_context' => ['groups' => ['commande']],
            ],
            'PUT','PATCH'
        ]
)]

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["commande","client:read","zone"])]
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    
    #[ORM\Column(type: 'string', nullable: true)]
    #[Groups(["commande","client:read","zone"])]
    private $isEtat;

    #[ORM\Column(type: 'string', nullable: true)]
    #[Groups(["commande","client:read","zone"])]
    private $numero;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(["commande","client:read","zone"])]
    private $date;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    #[Groups(["commande","zone"])]
    private $client;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: LigneDeCommande::class,cascade:['persist'])]
    #[SerializedName("Produits")]
    #[Groups(["commande","client:read","zone"])]
    private $ligneDeCommandes;

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    private $livraison;

    #[ORM\Column(type: 'boolean', nullable: true)]
    #[Groups(["commande","client:read","zone"])]
    private $expedie=false;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'commandes')]
    #[Groups(["commande","client:read"])]
    private $zone;

    #[ORM\Column(type: 'boolean', nullable: true)]
    #[Groups(["commande","client:read"])]
    private $modeReception=true;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(["commande","client:read"])]
    private $prix;


    public function __construct()
    {
        $this->ligneDeCommandes = new ArrayCollection();
        $this->date=new \DateTime();
        $this->numero="NUMERO".date("dmYhis");
        $this->isEtat="en cours";
    }

    public function isIsEtat(): ?string
    {
        return $this->isEtat;
    }

    public function setIsEtat(?string $isEtat): self
    {
        $this->isEtat = $isEtat;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(?string $numero): self
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

    public function isExpedie(): ?bool
    {
        return $this->expedie;
    }

    public function setExpedie(?bool $expedie): self
    {
        $this->expedie = $expedie;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function isModeReception(): ?bool
    {
        return $this->modeReception;
    }

    public function setModeReception(?bool $modeReception): self
    {
        $this->modeReception = $modeReception;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
