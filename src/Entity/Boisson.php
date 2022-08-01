<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: BoissonRepository::class)]
#[ApiResource(
    subresourceOperations: [
        'boisson_get_subresource' => [
            'method' => 'GET',
            'path' => '/boissons/{id}/boisson_tailles',
        ],
    ],
)]
class Boisson extends Produit
{
    #[ApiSubresource()] 
    #[ORM\OneToMany(mappedBy: 'boisson', targetEntity: BoissonTaille::class)]
    private $boissonTailles;

    public function __construct()
    {
        parent::__construct();
        $this->boissonTailles = new ArrayCollection();
    }

    /**
     * @return Collection<int, BoissonTaille>
     */
    public function getBoissonTailles(): Collection
    {
        return $this->boissonTailles;
    }

    public function addBoissonTaille(BoissonTaille $boissonTaille): self
    {
        if (!$this->boissonTailles->contains($boissonTaille)) {
            $this->boissonTailles[] = $boissonTaille;
            $boissonTaille->setBoisson($this);
        }

        return $this;
    }

    public function removeBoissonTaille(BoissonTaille $boissonTaille): self
    {
        if ($this->boissonTailles->removeElement($boissonTaille)) {
            // set the owning side to null (unless already changed)
            if ($boissonTaille->getBoisson() === $this) {
                $boissonTaille->setBoisson(null);
            }
        }

        return $this;
    }
}
