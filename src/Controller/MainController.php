<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\Contact\ContactService;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_home")
     */
    public function home()
    {
        return $this->render('main/home.html.twig');
    }

    /**
     * @Route("/main/contact", name="main_contact")
     */
    public function formContact(Request $request, ContactNotification $contactNotification, ContactService $contactService)
    {
        $contact = new Contact();
  
        //formulaire de type ContactType
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request); // L'objet form dispose d'un gestionnaire de requete
                                        // Analyse si soumis ou pas, si les champs sont remplis etc... 
                                        // Puis bind l'ensemble des champs dans l'objet associé (ici product)
        
        /*if($form->isSubmitted() && $form->isValid()) {
            $contactNotification->notify($contact); 
            $this->addFlash('success','Votre message a bien été envoyé !');
            return $this->redirectToRoute('main_home', []);
        }*/
        if($form->isSubmitted() && $form->isValid()){
            $contactService->sendSimpleContactEmail($contact);
            $this->addFlash('success','Votre message a bien été envoyé, nous vous répondrons dès que possible !');
            return $this->redirectToRoute('main_home');
        }
                                        
        return $this->render('main/contact.html.twig', [
            'formContact' => $form->createView()
        ]);
    }

    /**
     * @Route("/main/order_info", name="main_order_info")
     */
    public function orderInfo()
    {
        return $this->render('main/orderInfo.html.twig');
    }

}
