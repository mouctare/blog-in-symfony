<?php

namespace App\Entity;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
/**
 * @ORM\Entity
 * @UniqueEntity(fields="email", message="L'mail  que vous avez indiqué est déjà utilisé ")
 
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    
    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\Length(min="8", minMessage="Votre mot de passe doit faire minimum 8 caractères")
     
     */
    private $password;
    /**
     * @Assert\EqualTo(propertyPath="password",message="Vous n'avez pas tapez le meme mot de passe")
     */

    public $confirm_password;

    public function getId(){


        return $this->id;
    }

    

    // other properties and methods

    public function getEmail(): ?string 
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    
   

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getSalt()
    {
        // The bcrypt and argon2i algorithms don't require a separate salt.
    
    }  
    

    public function eraseCredentials()
    {

    }  
    public function getRoles() {

        return [ 'ROLE_USER'];
    }
}