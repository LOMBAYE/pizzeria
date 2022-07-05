<?php

namespace App\DataProvider;

use App\Entity\Complement;
use App\Repository\BoissonTailleRepository;
use App\Repository\FritesPortionRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

class ComplementDataProvider implements ContextAwareCollectionDataProviderInterface,RestrictedDataProviderInterface{
    public function __construct(BoissonTailleRepository $boisson,FritesPortionRepository $frites) {
        $this->boisson = $boisson;
        $this->frites = $frites;
    }
    
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Complement::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        $tab =  [];
        $tab[] = $this->boisson->findAll();
        $tab[] = $this->frites->findAll();
        
        return $tab;
    }
}