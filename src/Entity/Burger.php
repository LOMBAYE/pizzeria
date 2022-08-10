<?php

namespace App\Entity;

use App\Entity\Menu;
use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    collectionOperations:[
        "GET"=>[
            'normalization_context' => ['groups' => ['simple']]
        ],
        "POST"=>[
            'normalization_context' => ['groups' => ['ajout:burger']],
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message"=>"Vous n'avez pas access à cette Ressource",
        ],
        ],
        itemOperations:[
            "get"=>[
            'method' => 'get',
            "path"=>"/burgers/{id}" ,
            'requirements' => ['id' => '\d+'],
            'normalization_context' => ['groups' => ['simple']],
            ],
            "delete"=>[
                "path"=>"/burgers/{id}" ,
                "security" => "is_granted('ROLE_GESTIONNAIRE')",
                "security_message"=>"Vous n'avez pas access à cette Ressource",
            ],
            "put"=>[
                "security" => "is_granted('ROLE_GESTIONNAIRE')",
                "security_message"=>"Vous n'avez pas access à cette Ressource",
            ]
            ]
)]

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
class Burger extends Produit
{
    #[Groups(["menu:simple"])]
    #[ORM\OneToMany(mappedBy: 'burgers', targetEntity: MenuBurger::class,cascade:['persist'])]
    private $menuBurgers;

    public function __construct()
    {   
        $this->menuBurgers = new ArrayCollection();
    }

    /**
     * @return Collection<int, MenuBurger>
     */
    public function getMenuBurgers(): Collection
    {
        return $this->menuBurgers;
    }

    public function addMenuBurger(MenuBurger $menuBurger): self
    {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setBurgers($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getBurgers() === $this) {
                $menuBurger->setBurgers(null);
            }
        }

        return $this;
    }

}
