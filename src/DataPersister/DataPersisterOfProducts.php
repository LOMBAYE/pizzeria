<?php

namespace App\DataPersister;

use App\Entity\Menu;
use App\Entity\Burger;
use App\Entity\Produit;
use App\Entity\Taille;
use App\Entity\BoissonTaille;
use App\Entity\FritesPortion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        if ($data instanceof Menu) {
            $prix=0;
            foreach ($data ->getMenuBurgers() as $menuBurger){
                dd($menuBurger->getBurgers()->getNom());
                $prix+=$menuBurger->getBurgers()->getPrix()*$menuBurger->getQuantite();
            }
            // foreach ($data->getTailles() as $taille){
            //     // $prix+=$taille->getPrix();
            // }
            foreach ($data->getFrites() as $frite){
                $prix+=$frite->getPrix();
            }
            $prix-=floor($prix*5/100);
            $data->setPrix($prix);
        }
        if($data instanceof Produit){
           $image=$data->getBImage();
           $data->setImage(file_get_contents($image));
        }
        if($data instanceof BoissonTaille){
            $image=$data->getFakeImg();
            $data->setImage(file_get_contents($image));
         }
        
        $this->_entityManager->persist($data);
        $this->_entityManager->flush();

    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {
        if($data instanceof Burger){
          dd($data->getMenuBurgers());
            if(count($data->getMenuBurgers())===0){
                $data->setIsEtat(false);
                // return new JsonResponse(['error' => 'PRODUIT EXISTANT DANS UN MENU!'],Response::HTTP_BAD_REQUEST);
            }
            
        }else{
            $data->setIsEtat(false);
        }
        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
    }
}