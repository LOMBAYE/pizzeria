<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleRepository::class)]
#[ApiResource(
    collectionOperations:[
        'GET'=>[
            'normalization_context' => ['groups' => ["taille:read"]],
            
        ],"POST"
    ],
    itemOperations:[
        'GET'=>['normalization_context'=>['groups' => ['taille:read']]]
    ]
)]
class Taille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["menu:read","taille:read","simple"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["menu:read","taille:read","simple"])]
    private $libelle;

    #[ApiSubresource()] 
    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: BoissonTaille::class)]
    #[Groups(["menu:read","taille:read"])]
    private $boissonTailles;

    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: TailleMenu::class)]
    private $tailleMenus;

    public function __construct()
    {
        // $this->menus = new ArrayCollection();
        $this->boissonTailles = new ArrayCollection();
        $this->tailleMenus = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }




  
        /**
     * @return Collection<int, BoissonTaille>
     */
    public function getBoissonTailles(): Collection
    {
        return $this->boissonTailles;
    }

    public function addBoissonTaille(BoissonTaille $boissonTaille): self
    {
        if (!$this->boissonTailles->contains($boissonTaille)) {
            $this->boissonTailles[] = $boissonTaille;
            $boissonTaille->setTaille($this);
        }

        return $this;
    }

    public function removeBoissonTaille(BoissonTaille $boissonTaille): self
    {
        if ($this->boissonTailles->removeElement($boissonTaille)) {
            // set the owning side to null (unless already changed)
            if ($boissonTaille->getTaille() === $this) {
                $boissonTaille->setTaille(null);
            }
        }

        return $this;
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
            $tailleMenu->setTaille($this);
        }

        return $this;
    }

    public function removeTailleMenu(TailleMenu $tailleMenu): self
    {
        if ($this->tailleMenus->removeElement($tailleMenu)) {
            // set the owning side to null (unless already changed)
            if ($tailleMenu->getTaille() === $this) {
                $tailleMenu->setTaille(null);
            }
        }

        return $this;
    }
}
