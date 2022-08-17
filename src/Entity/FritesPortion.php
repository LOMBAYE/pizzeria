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
            // 'normalization_context' => ['groups' => ['simple']],
            // "security" => "is_granted('ROLE_GESTIONNAIRE')",
            // "security_message"=>"Vous n'avez pas access à cette Ressource", 
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


    #[ORM\OneToMany(mappedBy: 'frite', targetEntity: MenuFrite::class)]
    private $menuFrites;

    public function __construct()
    {
        parent::__construct();
        $this->menuFrites = new ArrayCollection();
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
            $menuFrite->setFrite($this);
        }

        return $this;
    }

    public function removeMenuFrite(MenuFrite $menuFrite): self
    {
        if ($this->menuFrites->removeElement($menuFrite)) {
            // set the owning side to null (unless already changed)
            if ($menuFrite->getFrite() === $this) {
                $menuFrite->setFrite(null);
            }
        }

        return $this;
    }


 
}
