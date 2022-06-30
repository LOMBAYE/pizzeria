<?php

namespace App\DataPersister;

use App\Entity\Menu;
use App\Entity\Produit;
use App\Entity\BoissonTaille;
use App\Entity\FritesPortion;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

/**
 *
 */
class DataPersisterOfProducts implements ContextAwareDataPersisterInterface
{
    private $_entityManager;

    public function __construct(  EntityManagerInterface $entityManager) { 
        $this->_entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Produit;
    }

    /**
     * @param Produit $data
     */
    public function persist($data, array $context = [])
    {
        if ($data instanceof BoissonTaille or $data instanceof FritesPortion) {
            $data->setPrix((0));
        } elseif ($data instanceof Menu) {
            $prix=0;
            foreach ($data ->getBurgers() as $burger){
                $prix+=$burger->getPrix();
            }
            foreach ($data->getBoissons() as $boisson){
                $prix+=$boisson->getPrix();
            }
            foreach ($data->getFrites() as $frite){
                $prix+=$frite->getPrix();
            }
            $prix-=floor($prix*5/100);
            $data->setPrix($prix);
        }
        
        $this->_entityManager->persist($data);
        $this->_entityManager->flush();

    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {
        $this->_entityManager->remove($data);
        $this->_entityManager->flush();
    }
}