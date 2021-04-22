<?php

namespace App\Service\Contact;

use App\Entity\Contact;
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
                        ->htmlTemplate('email/registrationConfirmation.html.twig')

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
                        ->to(new Address("thibaultfertdev@gmail.com"))
                        ->subject('Email de contact venant du site Alacart.fr')
                        // path of the Twig template to render
                        ->htmlTemplate('email/simpleContact.html.twig')
                        // pass variables (name => value) to the template
                        ->context([                           
                            'contact' => $contact
                        ]);
        $this->mailer->send($email);
    }


}
