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

    collectionOperations:[
        "GET"=>[
            'normalization_context' => ['groups' => ['menu:read']],
        ],
        'POST'=>[
            'denormalization_context' => ['groups' => ['add:menu']],
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
            'normalization_context' => ['groups' => ['menu:read']],
            ],
            "delete"=>[
                "path"=>"/menus/{id}",
                'normalization_context' => ['groups' => ['menu:read']],
                "security" => "is_granted('ROLE_GESTIONNAIRE')",
                "security_message"=>"Vous n'avez pas access à cette Ressource",  
            ],
            "put"=>[
                'normalization_context' => ['groups' => ['menu:read']],
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
    #[Groups(['menu:read','add:menu'])]
    protected $nom;

    #[ORM\Column(type: 'integer')]
    #[Groups(['menu:read'])]
    protected $prix;

    #[ORM\OneToMany(mappedBy: 'menus', targetEntity: MenuBurger::class,cascade:['persist'])]
    #[Groups(['menu:read','add:menu'])]
    #[SerializedName("burgers")]
    private $menuBurgers;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: TailleMenu::class,cascade:['persist'])]
    #[ApiSubresource()]
    #[Groups(['menu:read','add:menu'])]
    #[SerializedName("tailles")]
    private $tailleMenus;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuFrite::class,cascade:['persist'])]
    #[Groups(['menu:read','add:menu'])]
    #[SerializedName("frites")]
    private $menuFrites;

    public function __construct()
    {   
        $this->menuBurgers = new ArrayCollection();
        $this->tailleMenus = new ArrayCollection();
        $this->menuFrites = new ArrayCollection();
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

    /**
     * @return Collection<int, TailleMenu>
     */
    public function getTailleMenus(): Collection
    {
        return $this->tailleMenus;
    }

    public function addTailleMenu(TailleMenu $tailleMenu): self
    {
        if (!$this->tailleMenus->contains($tailleMenu)) {
            $this->tailleMenus[] = $tailleMenu;
            $tailleMenu->setMenu($this);
        }

        return $this;
    }

    public function removeTailleMenu(TailleMenu $tailleMenu): self
    {
        if ($this->tailleMenus->removeElement($tailleMenu)) {
            // set the owning side to null (unless already changed)
            if ($tailleMenu->getMenu() === $this) {
                $tailleMenu->setMenu(null);
            }
        }

        return $this;
    }

    public function addTaille(Taille $taille,int $qt=1){
        $tailleMenu= new TailleMenu();
        $tailleMenu->setTaille($taille);
        $tailleMenu->setMenu($this);
        $tailleMenu->setQuantite($qt);
        $this->addTailleMenu($tailleMenu);
    }

    /**
     * @return Collection<int, MenuFrite>
     */
    public function getMenuFrites(): Collection
    {
        return $this->menuFrites;
    }

    public function addMenuFrite(MenuFrite $menuFrite): self
    {
        if (!$this->menuFrites->contains($menuFrite)) {
            $this->menuFrites[] = $menuFrite;
            $menuFrite->setMenu($this);
        }

        return $this;
    }

    public function removeMenuFrite(MenuFrite $menuFrite): self
    {
        if ($this->menuFrites->removeElement($menuFrite)) {
            // set the owning side to null (unless already changed)
            if ($menuFrite->getMenu() === $this) {
                $menuFrite->setMenu(null);
            }
        }

        return $this;
    }

    public function addFrite(FritesPortion $frite,int $qt=1){
        $menuFrite= new MenuFrite();
        $menuFrite->setFrite($frite);
        $menuFrite->setMenu($this);
        $menuFrite->setQuantite($qt);
        $this->addMenuFrite($menuFrite);
    }
}
