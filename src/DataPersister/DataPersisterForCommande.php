<?php

namespace App\DataPersister;

use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

/**
 *
 */
class DataPersisterForCommande implements ContextAwareDataPersisterInterface
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
        return $data instanceof Commande;
    }

    /**
     * @param Commande $data
     */
    public function persist($data, array $context = [])
    {
        if ($data instanceof Commande) {
            // foreach(($data->getLigneDeCommandes()));
            foreach($data->getLigneDeCommandes() as $ligne) {
               $ligne->setPrix(($ligne->getProduit()->getPrix())*($ligne->getQuantite()));
            }
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