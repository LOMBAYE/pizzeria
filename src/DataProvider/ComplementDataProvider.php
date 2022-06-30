<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use App\Entity\BoissonTaille;
use App\Entity\FritesPortion;
use App\Repository\BoissonTailleRepository;
use App\Repository\FritesPortionRepository;

class ComplementDataProvider implements ContextAwareCollectionDataProviderInterface{
    public function __construct(BoissonTailleRepository $boisson,FritesPortionRepository $frites) {
        $this->boisson = $boisson;
        $this->frites = $frites;
    }
    
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return BoissonTaille::class or FritesPortion::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        $tab =  [];
        $tab[] = $this->boisson->findAll();
        $tab[] = $this->frites->findAll();
        
        return $tab;
        
    }
}