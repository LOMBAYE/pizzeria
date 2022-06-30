<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ComplementRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

#[ApiResource(
    collectionOperations:[
        'GET' => [
            'method' => 'GET',
            'path' => '/complements'
        ]
    ]
)]

// #[ORM\Entity(repositoryClass: ComplementRepository::class)]

class Complement 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\OneToMany(mappedBy: 'complement', targetEntity: FritesPortion::class)]
    private $frites;

    #[ORM\OneToMany(mappedBy: 'complement', targetEntity: BoissonTaille::class)]
    private $boissons;

    public function __construct()
    {
        $this->frites = new ArrayCollection();
        $this->boissons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, FritesPortion>
     */
    public function getFrites(): Collection
    {
        return $this->frites;
    }

    // public function addFrite(FritesPortion $frite): self
    // {
    //     if (!$this->frites->contains($frite)) {
    //         $this->frites[] = $frite;
    //         $frite->setComplement($this);
    //     }

    //     return $this;
    // }

    // public function removeFrite(FritesPortion $frite): self
    // {
    //     if ($this->frites->removeElement($frite)) {
    //         // set the owning side to null (unless already changed)
    //         if ($frite->getComplement() === $this) {
    //             $frite->setComplement(null);
    //         }
    //     }

    //     return $this;
    // }

    /**
     * @return Collection<int, BoissonTaille>
     */
    public function getBoissons(): Collection
    {
        return $this->boissons;
    }

    // public function addBoisson(BoissonTaille $boisson): self
    // {
    //     if (!$this->boissons->contains($boisson)) {
    //         $this->boissons[] = $boisson;
    //         $boisson->setComplement($this);
    //     }

    //     return $this;
    // }

    // public function removeBoisson(BoissonTaille $boisson): self
    // {
    //     if ($this->boissons->removeElement($boisson)) {
    //         // set the owning side to null (unless already changed)
    //         if ($boisson->getComplement() === $this) {
    //             $boisson->setComplement(null);
    //         }
    //     }

    //     return $this;
    // }


  
}
