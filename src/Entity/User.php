<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use App\Controller\ValidEmailActions;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name:'`user`')]

#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"role", type:"string")]
#[ORM\DiscriminatorMap(["gestionnaire"=>"Gestionnaire", "client"=>"Client", "livreur"=>"Livreur"])]
// #[UniqueEntity(fields: ['login'], message: 'There is already an account with this login')]

#[ApiResource(
    collectionOperations:[
        'get','post'=>[
            'method' => 'GET',
            'normalization_context'=>[
                'groups'=>[
                    'read:users'
                ]
            ]
        ],
        'change'=>[
            'method'=>'PATCH',
            'deserialize'=>false,
            'path'=>'users/validate/{token}',
            'controller'=>ValidEmailActions::class
        ]
        ],
        itemOperations:[]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface{
   
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    
    #[Groups(['read:users',"all"])]
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    protected $email;

    #[Groups(['read:users'])]
    #[ORM\Column(type: 'json')]
    protected $roles = [];

    #[ORM\Column(type: 'string')]
    protected $password;

    #[Groups(['read:users','all'])]
    #[ORM\Column(type: 'string', length: 255)]
    protected $nomComplet;

    // #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[SerializedName("password")]
    protected $plainPassword;

    #[ORM\Column(type: 'string', length: 255)]
    protected $token;

    #[ORM\Column(type: 'boolean')]
    protected $isEnable=false;

    #[ORM\Column(type: 'datetime')]
    protected $expireAt;

    public function __construct(){
        $this->expireAt=new \DateTime("+1 day");
        $this->token=str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(random_bytes(128)));
   }

    public function getId(): ?int
    {
        return $this->id;
    }
 
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }

    public function setNomComplet(string $nomComplet): self
    {
        $this->nomComplet = $nomComplet;

        return $this;
    }


    public function isIsEnable(): ?bool
    {
        return $this->isEnable;
    }

    public function setIsEnable(?bool $isEnable): self
    {
        $this->isEnable = $isEnable;

        return $this;
    }


    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getExpireAt(): ?\DateTimeInterface
    {
        return $this->expireAt;
    }

    public function setExpireAt(\DateTimeInterface $expireAt): self
    {
        $this->expireAt = $expireAt;

        return $this;
    }
 

}
