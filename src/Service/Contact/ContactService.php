<?php

namespace App\Service\Contact;

use App\Entity\Contact;
use App\Service\Cart\CartService;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class ContactService {

    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendRegistrationConfirmationEmail ($emailAdress, $token)
    {
        $email = (new TemplatedEmail())
                        ->from('noreply@alacart.com')
                        ->to(new Address($emailAdress))
                        ->subject('Bienvenue chez Alacart\' !')

                        // path of the Twig template to render
                        ->htmlTemplate('email/registrationConfirmationEmail.html.twig')

                        // pass variables (name => value) to the template
                        ->context([                           
                            'token' => $token
                        ]);
        $this->mailer->send($email);
    }

    public function sendSimpleContactEmail (Contact $contact)
    {
        $email = (new TemplatedEmail())
                        ->from($contact->getEmail())
                        ->to(new Address("alacart.distribution@gmail.com"))
                        ->cc("alacart.website@gmail.com")
                        ->subject('Email de contact venant du site Alacart.fr')
                        // path of the Twig template to render
                        ->htmlTemplate('email/simpleContactEmail.html.twig')
                        // pass variables (name => value) to the template
                        ->context([                           
                            'contact' => $contact
                        ]);
        $this->mailer->send($email);
    }
    
    public function sendCartEmail (Contact $contact, array $items, float $total)
    {
        $email = (new TemplatedEmail())
                        ->from($contact->getEmail())
                        ->to(new Address("alacart.distribution@gmail.com"))
                        ->cc("alacart.website@gmail.com")
                        ->subject('Commande passée sur le site Alacart.fr')
                        // path of the Twig template to render
                        ->htmlTemplate('email/cartEmail.html.twig')
                        // pass variables (name => value) to the template
                        ->context([                           
                            'contact' => $contact,
                            'items' => $items,
                            'total' => $total
                        ]);
        $this->mailer->send($email);
    }


}
