<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ComplementRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\Collection;
use App\DataProvider\ComplementDataProvider;
use Doctrine\Common\Collections\ArrayCollection;

#[ApiResource(
    normalizationContext:["groups"=>['simple']],
    collectionOperations:[
        'GET' => [
            'path' => '/complements',
        ]
        ],
    itemOperations:[]    
)]

// #[ORM\Entity(repositoryClass: ComplementRepository::class)]
// #[ORM\MappedSuperclass]
class Complement 
{
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column(type: 'integer')]
    protected $id;


    // public function getId(): ?int
    // {
    //     return $this->id;
    // }
  
  
}
