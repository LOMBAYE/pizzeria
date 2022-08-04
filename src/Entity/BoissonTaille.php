<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonTailleRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ApiResource()]

#[ORM\Entity(repositoryClass: BoissonTailleRepository::class)]
class BoissonTaille 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["simple"])]
    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(["menu:read","simple"])]
    private $qteEnStock;

    #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'boissonTailles')]
    #[Groups(["simple"])]
    private $taille;

    #[ORM\ManyToOne(targetEntity: Boisson::class, inversedBy: 'boissonTailles')]
    #[Groups(["menu:read","taille:read","simple"])]
    private $boisson;

    #[ORM\Column(type: 'blob', nullable: true)]
    #[Groups(['simple'])]
    private $image;

    #[SerializedName("image")]
    protected $fakeImg;
   
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

    public function getImage(): ?string
    {
        return (is_resource($this->image)?utf8_encode(base64_encode(stream_get_contents($this->image))):$this->image);    
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }


    /**
     * Get the value of fakeImg
     */ 
    public function getFakeImg()
    {
        return $this->fakeImg;
    }

    /**
     * Set the value of fakeImg
     *
     * @return  self
     */ 
    public function setFakeImg($fakeImg)
    {
        $this->fakeImg = $fakeImg;

        return $this;
    }
}
