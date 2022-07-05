<?php

namespace App\Entity;

use App\Entity\Burger;
use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
#[ApiResource(
    collectionOperations:[
        "GET"=>[
            'normalization_context' => ['groups' => ['simple']],
        ],"POST"=>[
            'normalization_context' => ['groups' => ['simple']],
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message"=>"Vous n'avez pas access à cette Ressource", 
        ]
        ],
        itemOperations:[
            "get"=>[
            'method' => 'get',
            "path"=>"/menus/{id}" ,
            'requirements' => ['id' => '\d+'],
            'normalization_context' => ['groups' => ['all']],
            ],
            "delete"=>[
                "path"=>"/menus/{id}",
                'normalization_context' => ['groups' => ['simple']],
                "security" => "is_granted('ROLE_GESTIONNAIRE')",
                "security_message"=>"Vous n'avez pas access à cette Ressource",  
            ],
            "put"=>[
                'normalization_context' => ['groups' => ['simple']],
                "security" => "is_granted('ROLE_GESTIONNAIRE')",
                "security_message"=>"Vous n'avez pas access à cette Ressource", 
            ]
            ]
)]

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu  extends Produit
{
    #[Assert\NotBlank(message:"Burger Obligatoire")]
    #[ORM\ManyToMany(targetEntity: Burger::class, inversedBy: 'menus')]
    private $burgers;

    #[ORM\ManyToMany(targetEntity: BoissonTaille::class, inversedBy: 'menus')]
    private $boissons;

    #[ORM\ManyToMany(targetEntity: FritesPortion::class, inversedBy: 'menus')]
    private $frites;

    public function __construct()
    {   
        $this->burgers = new ArrayCollection();
        $this->boissons = new ArrayCollection();
        $this->frites = new ArrayCollection();
    }

    /**
     * @return Collection<int, Burger>
     */
    public function getBurgers(): Collection
    {
        return $this->burgers;
    }

    public function addBurger(Burger $burger): self
    {
        if (!$this->burgers->contains($burger)) {
            $this->burgers[] = $burger;
        }

        return $this;
    }

    public function removeBurger(Burger $burger): self
    {
        $this->burgers->removeElement($burger);

        return $this;
    }

    /**
     * @return Collection<int, BoissonTaille>
     */
    public function getBoissons(): Collection
    {
        return $this->boissons;
    }

    public function addBoisson(BoissonTaille $boisson): self
    {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons[] = $boisson;
        }

        return $this;
    }

    public function removeBoisson(BoissonTaille $boisson): self
    {
        $this->boissons->removeElement($boisson);

        return $this;
    }

    /**
     * @return Collection<int, FritesPortion>
     */
    public function getFrites(): Collection
    {
        return $this->frites;
    }

    public function addFrite(FritesPortion $frite): self
    {
        if (!$this->frites->contains($frite)) {
            $this->frites[] = $frite;
        }

        return $this;
    }

    public function removeFrite(FritesPortion $frite): self
    {
        $this->frites->removeElement($frite);

        return $this;
    }

}
