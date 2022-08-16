<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    collectionOperations:[
        "GET"=>[
            'normalization_context' => ['groups' => ['livraison']],
            // "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message"=>"Vous n'avez pas acces à cette Ressource",
        ],"POST"
    ],
    itemOperations:[
        'get'=>[
            'normalization_context' => ['groups' => ['livraison']],
        ]
    ]
)]

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["livraison"])]
    private $id;

    #[ORM\Column(type: 'boolean', nullable: true)]
    #[Groups(["livraison"])]
    private $isEtat=true;

    #[ORM\OneToMany(mappedBy: 'livraison', targetEntity: Commande::class)]
    #[Groups(["livraison"])]
    private $commandes;

    #[ORM\ManyToOne(targetEntity: Livreur::class, inversedBy: 'livraisons')]
    #[Groups(["livraison"])]
    private $livreur;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'livraisons')]
    #[Groups(["livraison"])]
    private $zone;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'livraisons')]
    private $gestionnaire;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(["livraison"])]
    private $date;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->date = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setLivraison($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getLivraison() === $this) {
                $commande->setLivraison(null);
            }
        }

        return $this;
    }

    public function getLivreur(): ?Livreur
    {
        return $this->livreur;
    }

    public function setLivreur(?Livreur $livreur): self
    {
        $this->livreur = $livreur;

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

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

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
 
   
}
