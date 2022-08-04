<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FritesPortionRepository;
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
            'normalization_context' => ['groups' => ['simple']],
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message"=>"Vous n'avez pas access à cette Ressource", 
        ]
        ],
        itemOperations:[
            "get"=>[
            "path"=>"/frites_portions/{id}" ,
            'requirements' => ['id' => '\d+'],
            'normalization_context' => ['groups' => ['all']],
            ],
            "delete"=>[
                "path"=>"/frites_portions/{id}",
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
#[ORM\Entity(repositoryClass: FritesPortionRepository::class)]
class FritesPortion extends Produit
{
   
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["simple"])]
    private $portions;

    
    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'frites')]
    private $menus;

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
