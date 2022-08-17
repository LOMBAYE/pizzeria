<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuFriteRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuFriteRepository::class)]
class MenuFrite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(["menu:read",'add:menu'])]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: FritesPortion::class, inversedBy: 'menuFrites')]
    #[Groups(["menu:read",'add:menu'])]
    private $frite;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuFrites')]
    private $menu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getFrite(): ?FritesPortion
    {
        return $this->frite;
    }

    public function setFrite(?FritesPortion $frite): self
    {
        $this->frite = $frite;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }
}
