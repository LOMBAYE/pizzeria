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
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\SerializedName;
#[ApiResource(
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
    #[Groups(["menu:simple"])]
    #[ORM\Column(type: 'string', length: 255)]
    protected $nom;

    #[Groups([ "menu:simple"])]
    #[ORM\Column(type: 'integer')]
    protected $prix;

    
    #[Groups(["menu:read","menu:simple"])]
    #[ORM\ManyToMany(targetEntity: BoissonTaille::class, inversedBy: 'menus',cascade:['persist'])]
    private $boissons;

    #[Groups(["menu:read","menu:simple"])]
    #[ORM\ManyToMany(targetEntity: FritesPortion::class, inversedBy: 'menus',cascade:['persist'])]
    private $frites;

    #[Groups(["menu:read","menu:simple"])]
    #[ORM\OneToMany(mappedBy: 'menus', targetEntity: MenuBurger::class,cascade:['persist'])]
    #[SerializedName("Burgers")]
    private $menuBurgers;

    // #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuTaille::class)]
    // private $menuTailles;

    public function __construct()
    {   
        $this->boissons = new ArrayCollection();
        $this->frites = new ArrayCollection();
        $this->menuBurgers = new ArrayCollection();
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
