<?php
namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ValidEmailActions extends AbstractController
{
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager= $manager;
    }

  
    public function __invoke (EntityManagerInterface $manager,Request $request,UserRepository $userR)
    {
        $token=$request->get('token');
        $user=$userR->findOneBy(['token' => $token]);
        if (!$user) {
            return new JsonResponse(['error' => 'Invalid token'],Response::HTTP_BAD_REQUEST);
        }
        if ($user->isIsEnable()) {
            return new JsonResponse(['message' => 'Compte existant!'],Response::HTTP_BAD_REQUEST);
        }
        if ($user->getExpireAt()< new \DateTime()) {
            return new JsonResponse(['message' => 'Token expire'],Response::HTTP_BAD_REQUEST);
        }
        $user->setIsEnable(true);
          $manager->flush();
        return new JsonResponse(["message' => 'Compte cree avec succes"],Response::HTTP_OK);
    }
    

    
}