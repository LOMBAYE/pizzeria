<?php

namespace App\Controller;

use App\Entity\Plateau;
use App\Repository\BeignetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PlateauController extends AbstractController{
    
    public function __invoke(Request $request,EntityManagerInterface $entityManager,BeignetRepository $br){
        $content=json_decode( $request->getContent());
        if(!isset( $content->nom)){
          return  $this->json('Nom Obligatoire',400);
        }
        $plat=new Plateau();
        $plat->setNom($content->nom);
        $plat->setPrix($content->prix);
        foreach($content->beignets as $b) {
          $beignet=$br->find($b->beignet);
          if($beignet){
              $plat->addBeignet($beignet,$b->quantite);
          }
        }
        $entityManager->persist($plat);
        $entityManager->flush();
        return  $this->json('Succes',201);

        // if(isset)
    }
}