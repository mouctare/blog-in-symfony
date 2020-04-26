<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\RegistrationType;

//use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends abstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request,  EntityManagerInterface $entityManager ,UserPasswordEncoderInterface $encoder)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('security_login');
        }

        return $this->render(
            'security/registration.html.twig',
            array('form' => $form->createView())
        );
    }
      /**
     * @Route("/connexion", name="security_login")
     */

     public function login() {
        return $this->render(
            'security/login.html.twig');


     }
      /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout(){}
}

