<?php

namespace App\Services;

use Twig\Environment;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Config\Framework\MailerConfig;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MailService{
   
    public function __construct(MailerInterface $mailer,Environment $environment) {
        $this->mailer = $mailer;
        $this->environment=$environment;
    }

    public function sendMail($data,$subject="Nouveau Compte"){
        $email=new Email();
        $email->from("aa@a.com")
            ->to($data->getEmail())
            ->subject($subject)
            ->html($this->environment->render('test/test.html.twig',
                ["nom"=>$data->getNomComplet(),
                "token"=>$data->getToken()]));
        $this->mailer->send($email);
    }
}