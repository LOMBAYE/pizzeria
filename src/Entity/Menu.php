<?php

namespace App\Entity;

use App\Entity\Burger;
use App\Entity\Produit;
use App\Entity\MenuBurger;
use App\Controller\MenuAdd;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\SerializedName;
#[ApiResource(
    subresourceOperations: [
        'menu_get_subresource' => [
            'method' => 'GET',
            'path' => '/menus/{id}/tailles',
        ],
    ],
    collectionOperations:[
        "GET"=>[
            'normalization_context' => ['groups' => ['simple']],
        ],

        'menu'=>[
            'method'=>'POST',
            'deserialize'=>false,
            'path'=>'/menu2',
            'controller'=>MenuAdd::class
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
    #[Assert\NotBlank(message:"Le nom est Obligatoire")]
    #[ORM\Column(type: 'string', length: 255)]
    protected $nom;

    #[ORM\Column(type: 'integer')]
    protected $prix;

    #[Groups(["simple","all"])]
    #[ORM\ManyToMany(targetEntity:Taille::class, inversedBy: 'menus',cascade:['persist'])]
    #[ApiSubresource()]
    private $tailles;

    #[Groups(["simple"])]
    #[ORM\ManyToMany(targetEntity: FritesPortion::class, inversedBy: 'menus',cascade:['persist'])]
    #[ApiSubresource()]
    private $frites;

    #[Groups(["simple"])]
    #[ORM\OneToMany(mappedBy: 'menus', targetEntity: MenuBurger::class,cascade:['persist'])]
    #[SerializedName("burgers")]
    private $menuBurgers;

    // #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuTaille::class)]
    // private $menuTailles;

    public function __construct()
    {   
        $this->tailles = new ArrayCollection();
        $this->frites = new ArrayCollection();
        $this->menuBurgers = new ArrayCollection();
    }


    /**
     * @return Collection<int, Taille>
     */
    public function getTailles(): Collection
    {
        return $this->tailles;
    }

    public function addTaille(Taille $taille): self
    {
        if (!$this->tailles->contains($taille)) {
            $this->tailles[] = $taille;
        }

        return $this;
    }

    public function removeTaille(Taille $taille): self
    {
        $this->tailles->removeElement($taille);

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
            $menuBurger->setMenus($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getMenus() === $this) {
                $menuBurger->setMenus(null);
            }
        }

        return $this;
    }
    public function addBurger(Burger $burger,int $qt=1){
        $menuBurger= new MenuBurger();
        $menuBurger->setBurgers($burger);
        $menuBurger->setMenus($this);
        $menuBurger->setQuantite($qt);
        $this->addMenuBurger($menuBurger);
    }

    // /**
    //  * @return Collection<int, MenuTaille>
    //  */
    // public function getMenuTailles(): Collection
    // {
    //     return $this->menuTailles;
    // }

    // public function addMenuTaille(MenuTaille $menuTaille): self
    // {
    //     if (!$this->menuTailles->contains($menuTaille)) {
    //         $this->menuTailles[] = $menuTaille;
    //         $menuTaille->setMenu($this);
    //     }

    //     return $this;
    // }

    // public function removeMenuTaille(MenuTaille $menuTaille): self
    // {
    //     if ($this->menuTailles->removeElement($menuTaille)) {
    //         // set the owning side to null (unless already changed)
    //         if ($menuTaille->getMenu() === $this) {
    //             $menuTaille->setMenu(null);
    //         }
    //     }

    //     return $this;
    // }

}
