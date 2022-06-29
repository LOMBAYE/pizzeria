<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource()]

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
class Burger extends Produit
{
   
}
