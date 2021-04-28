<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Service\User\UserService;
use App\Service\Contact\ContactService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/registration", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, ContactService $contactService) {
        
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setEnable(false);
            $user->setToken($this->generateToken());
            $manager->persist($user);
            $manager->flush();
            $contactService->sendRegistrationConfirmationEmail($user->getEmail(), $user->getToken());
            $this->addFlash('success','Un email de confirmation vous a été envoyé. Merci de l\'ouvrir et suivre le lien pour finaliser la création de votre compte.');
            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig', [
            'formRegistration' => $form->createView()
        ]);

    }

    /**
     * @Route("/registration/confirmation/{token}", name="security_registration_confirmation")
     */
    //On arrive par cette route lorsque l'on suit le lien de confirmation (avec token joins) présent dans le mail envoyé pour valider l'inscription
    public function registrationConfirmation(string $token, EntityManagerInterface $manager, UserService $userService)
    {
        $user = $userService->getOneItemByToken($token);    // On cherche un user possédant ce token   

        if($user) {
            $user->setToken(null);
            $user->setEnable(true);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success','Votre compte a bien été crée !');
            return $this->redirectToRoute('security_login'); 
        } 
        else 
        {
            $this->addFlash('warning','Ce compte n\'existe pas !');
            return $this->redirectToRoute('security_login');
        }
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login() {
        
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout() {}

    /**
     * @Route("/login_failure", name="security_failure_login")
     */
    public function failureLogin() {
        $this->addFlash('warning','Email ou mot de passe erroné.');
        return $this->render('security/login.html.twig');
    }
    

    // Permet de générer le token utilisé pour la validation de création de compte utilisateur
    private function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
}
