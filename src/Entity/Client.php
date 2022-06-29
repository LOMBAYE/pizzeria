<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Commande;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

#[ApiResource()]

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client extends User
{
  
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $telephone;
    
    public function __construct()
    {
        parent::__construct();
        // $this->commandes = new ArrayCollection();
    }


    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

 


}
