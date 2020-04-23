<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *  fields={"email"}
 *  message= "L'email que vous avez indiqué est déjà utilisé !"
 * )
 */
class User 
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
    
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
      * @Assert\Length(min="8" , minMessage="Votre mot de passe doit faire minimum 8 caractères")
      * @Assert\EqualTo(propertyPath="confirm_password", message="Votre mot de passe doitre le meme que celiui que vous confirmez")
     */
    private $password;

    /**
     * * @Assert\EqualTo(propertyPath="password",message="Vous n'avez pas tanpé le meme mot de pass")
     */
    
    public $confirm_password;

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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
   // public function eraseCredentials(){} // on implément les methode le l'interface

  //  public function getSalt(){}
   // public function getRoles() {
     //   return ['ROLE_USER'];

      //  }
    //}
   }
   