<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ComplementRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\DataProvider\ComplementDataProvider;
use Doctrine\Common\Collections\ArrayCollection;

#[ApiResource(
    normalizationContext:["groups"=>['catalogue:read']],
    collectionOperations:[
        'GET' => [
            'path' => '/complements',
            'srccat'=>ComplementDataProvider::class
        ]
        ],
    itemOperations:[]    
)]

// #[ORM\Entity(repositoryClass: ComplementRepository::class)]

class Complement 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;


    public function getId(): ?int
    {
        return $this->id;
    }
  
  
}
