<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonTailleRepository;
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
            'method' => 'get',
            "path"=>"/boisson_tailles/{id}" ,
            'requirements' => ['id' => '\d+'],
            'normalization_context' => ['groups' => ['all']],
            ],
            "delete"=>[
                "path"=>"/boisson_tailles/{id}",
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

#[ORM\Entity(repositoryClass: BoissonTailleRepository::class)]
class BoissonTaille 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["simple"])]
    #[ORM\Column(type: 'integer', nullable: true)]
    private $qteEnStock;

    #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'boissonTailles')]
    private $taille;

    #[ORM\ManyToOne(targetEntity: Boisson::class, inversedBy: 'boissonTailles')]
    private $boisson;

    public function __construct()
    {
        // parent::__construct();
        // $this->menus = new ArrayCollection();
    }
     
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getQteEnStock(): ?int
    {
        return $this->qteEnStock;
    }

    public function setQteEnStock(?int $qteEnStock): self
    {
        $this->qteEnStock = $qteEnStock;

        return $this;
    }

    public function getTaille(): ?Taille
    {
        return $this->taille;
    }

    public function setTaille(?Taille $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getBoisson(): ?Boisson
    {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): self
    {
        $this->boisson = $boisson;

        return $this;
    }

}
