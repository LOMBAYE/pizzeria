<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\GestionnaireRepository;
use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource()]

#[ORM\Entity(repositoryClass: GestionnaireRepository::class)]
class Gestionnaire extends User
{
   
    public function getId(): ?int
    {
        return $this->id;
    }
}
