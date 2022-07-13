<?php

namespace App\DataPersister;

use App\Entity\Commande;
use App\Entity\Livraison;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\BoissonTaille;
use App\Repository\BoissonTailleRepository;
use App\Repository\LivreurRepository;

/**
 *
 */
class DataPersisterForCommande implements ContextAwareDataPersisterInterface
{
    private $_entityManager;

    public function __construct(  EntityManagerInterface $entityManager,
    LivreurRepository $livreurRepo) { 
        $this->_entityManager = $entityManager;
        $this->livreurRepo = $livreurRepo;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Commande or $data instanceof Livraison;
    }

    /**
     * @param Commande $data
     */
    public function persist($data, array $context = [])
    {
        if ($data instanceof Commande) {
            // dd($data->getLigneDeCommandes()[0]);
            foreach($data->getLigneDeCommandes() as $ligne) {
                if($ligne->getProduit() instanceof BoissonTaille){
                    if($ligne->getQuantite()>$ligne->getProduit()->getQteEnStock()){
                        return new JsonResponse(['error' => 'Boisson En rupture de Stock'],Response::HTTP_BAD_REQUEST);
                    }else{
                        $ligne->getProduit()->setQteEnStock($ligne->getProduit()->getQteEnStock()-$ligne->getQuantite());
                    }                 // $boisson=$this->boisTai->findById($ligne->getProduit()->getId());
                }
               $ligne->setPrix(($ligne->getProduit()->getPrix())*($ligne->getQuantite()));
            }
        } 
        if($data instanceof Livraison){
            foreach($data->getCommandes() as $commande){
                if($commande->isExpedie()){
                    return new JsonResponse(['error' => 'La commande '.$commande->getNumero().
                    ' est deja en livraison'],Response::HTTP_BAD_REQUEST);
                }
                $commande->setExpedie(true);
            }
            $livreurDispo=$this->livreurRepo->findByEtat('disponible');
            $count=count($livreurDispo)-1;
            $pos=rand(0,$count);
            if ($count>=0) {
                $data->setLivreur($livreurDispo[$pos]);
                $livreurDispo[$pos]->setEtat('indisponible');
            }else{
                return new JsonResponse(['error' => 
                'PAS DE LIVREUR DISPONIBLE'],Response::HTTP_BAD_REQUEST);
            }
            // dd($livreurDispo);
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