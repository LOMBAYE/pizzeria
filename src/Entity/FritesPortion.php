<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FritesPortionRepository;
use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource()]
#[ORM\Entity(repositoryClass: FritesPortionRepository::class)]
class FritesPortion extends Produit
{
   
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $portions;

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'frites')]
    private $menus;

    // #[ORM\ManyToOne(targetEntity: Complement::class, inversedBy: 'frites')]
    // private $complement;

    public function __construct()
    {
        parent::__construct();
        $this->menus = new ArrayCollection();
    }
   
    public function getPortions(): ?string
    {
        return $this->portions;
    }

    public function setPortions(?string $portions): self
    {
        $this->portions = $portions;

        return $this;
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->addFrite($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeFrite($this);
        }

        return $this;
    }

    // public function getComplement(): ?Complement
    // {
    //     return $this->complement;
    // }

    // public function setComplement(?Complement $complement): self
    // {
    //     $this->complement = $complement;

    //     return $this;
    // }


 
}
