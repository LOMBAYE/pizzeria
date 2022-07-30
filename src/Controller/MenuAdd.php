<?php
namespace App\Controller;

use App\Entity\Menu;
use App\Repository\BurgerRepository;
use App\Repository\TailleRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BoissonTailleRepository;
use App\Repository\FritesPortionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuAdd extends AbstractController{
 
    public function __invoke (EntityManagerInterface $manager,Request $request,BurgerRepository $burgerR,
    FritesPortionRepository $friteRepo,TailleRepository $tailleRepo){
        $parameters = json_decode($request->getContent());
        if(!isset($parameters->nom)){
            return  $this->json('Nom Obligatoire',400);
        }
        if(!isset($parameters->burgers) || count($parameters->burgers) == 0){
            return  $this->json('Champ Burger Obligatoire',400);
        }
        if(!isset($parameters->tailles) && !isset($parameters->frites)){
            return  $this->json('Un Complement est requis',400);
        }
        $prix=0;
        $menu=new Menu();
        $menu->setNom($parameters->nom);
        $menu->setImage(file_get_contents($parameters->bImage));
        foreach(($parameters->frites)[0] as $f){
            $frite=$friteRepo->find($f);
            if($frite){
                $prix+=$frite->getPrix();
                $menu->addFrite($frite);
            }else{
                return  $this->json('FRITE BII AMOUL!',400);
           }
        }
        foreach(($parameters->tailles)[0] as $b){
            $taille=$tailleRepo->find($b);
            if($taille){
                // $prix+=$taille->getPrix();
                $menu->addTaille($taille);
            }else{
                return  $this->json('Taille inexistante!',400);
           }
        }
        foreach($parameters->burgers as $b) {
            $burger=$burgerR->find($b->burger);
            if($burger){
                $prix+=($burger->getPrix())*$b->quantite;
                $menu->addBurger($burger,$b->quantite);
            }else{
                 return  $this->json('Ce burger n existe pas!',400);
            }
        }
        $menu->setPrix($prix);
        $manager->persist($menu);
        $manager->flush();
        return  $this->json('Menu Ajoute',201);
    }
}