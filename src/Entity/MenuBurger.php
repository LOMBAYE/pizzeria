<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuBurgerRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuBurgerRepository::class)]
class MenuBurger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["menu:read","menu:simple"])]
    #[ORM\Column(type: 'integer')]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuBurgers')]
    private $menus;

    #[Groups(["menu:read","menu:simple"])]
    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'menuBurgers')]
    private $burgers;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getMenus(): ?Menu
    {
        return $this->menus;
    }

    public function setMenus(?Menu $menus): self
    {
        $this->menus = $menus;

        return $this;
    }

    public function getBurgers(): ?Burger
    {
        return $this->burgers;
    }

    public function setBurgers(?Burger $burgers): self
    {
        $this->burgers = $burgers;

        return $this;
    }
}
