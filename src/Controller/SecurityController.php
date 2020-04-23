<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;



class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration") //cette function va etre éxécuté quand on appelle cette route
     */
   public function registration(Request $request,EntityManagerInterface $manager) {//UserPasswordEncoderInterface $encoder
       $user = new User();

       $form = $this->createForm(RegistrationType::class, $user);//on relie les champs du formulaire au champ de l'utilisateur.

       $form->handleRequest($request); //je veux que tu analyse c'est qui se pass dans la requetes
       if($form->isSubmitted() && $form->isValid()){
          // $hash = $encoder->encodePassword($user,$user->getPassword());

          // $user->setPassword($hash);// je modifie le mot de pass et je me le hash

           $manager->persist($user);
           $manager->flush();

       }


    

       return $this->render('security/registration.html.twig',[
           'form' => $form->createView()// je lui pass des variables qu'il puisse utilisé.
       ]);

   
}
}
