<?php

namespace App\EventSubscriber;

use App\Entity\Produit;
use App\Entity\Commande;
use Doctrine\ORM\Events;
use App\Entity\Livraison;
use App\Repository\LivreurRepository;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserSubscriber implements EventSubscriberInterface
{
    private ?TokenInterface $token;

    public function __construct(TokenStorageInterface $tokenStorage,LivreurRepository $livreurRepo){
        $this->token = $tokenStorage->getToken();
        $this->livreurRepo= $livreurRepo;
    }
    
    public static function getSubscribedEvents(): array{
        return [
            Events::prePersist,
            ];
    }

    private function getUser(){
        //dd($this->token);
        if (null === $token = $this->token) {
            return null;
        }
        if (!is_object($user = $token->getUser())) {
        // e.g. anonymous authentication
             return null;
        }
        return $user;
    }

    public function prePersist(LifecycleEventArgs $args) {
        if ($args->getObject() instanceof Produit) {
         $args->getObject()->setGestionnaire($this->getUser());
        }
        if ($args->getObject() instanceof Commande) {
            $args->getObject()->setClient($this->getUser());
        }
        if ($args->getObject() instanceof Livraison) {
            $args->getObject()->setGestionnaire($this->getUser());
        }
    }
}
