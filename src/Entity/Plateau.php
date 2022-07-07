<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\PlateauController;
use App\Repository\PlateauRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
#[ApiResource(
    collectionOperations:[
        "post","postBeignet"=>[
            "deserialize"=>false,
            "controller"=>PlateauController::class,
            "method"=>"post",
            "path"=>"/plateaux1"
        ]
    ]
)]
#[ORM\Entity(repositoryClass: PlateauRepository::class)]
class Plateau
{
    // symfony console d:s:u --force//pour ne pas persiser dans bd
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'integer')]
    private $prix;

    #[ORM\OneToMany(mappedBy: 'plateau', targetEntity: PlateauBeignet::class,cascade:['persist'])]
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

    public function getPrix(): ?int
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
            $plateauBeignet->setPlateau($this);
        }

        return $this;
    }

    public function removePlateauBeignet(PlateauBeignet $plateauBeignet): self
    {
        if ($this->plateauBeignets->removeElement($plateauBeignet)) {
            // set the owning side to null (unless already changed)
            if ($plateauBeignet->getPlateau() === $this) {
                $plateauBeignet->setPlateau(null);
            }
        }

        return $this;
    }
    public function addBeignet(Beignet $beignet,int $qt=1){
        $pb= new PlateauBeignet();
        $pb->setBeignet($beignet);
        $pb->setPlateau($this);
        $pb->setQuantite($qt);
        $this->addPlateauBeignet($pb);
    }
}
