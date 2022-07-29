<?php

namespace App\DataProvider;

use App\Entity\Catalogue;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;

final class CatalogueDataProvider implements ContextAwareCollectionDataProviderInterface,RestrictedDataProviderInterface{
    public function __construct(MenuRepository $menu,BurgerRepository $burger) {
        $this->menu = $menu;
        $this->burger = $burger;
    }
    
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Catalogue::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        $tab =  [];
        $tab['burgers'] = $this->burger->findAll();
        $tab['menus'] = $this->menu->findAll();
        // dd($tab['burgers']);      
        return $tab;
        
    }
}