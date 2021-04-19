<?php

namespace App\Notification;

use Twig\Environment;
use App\Entity\Contact;


class ContactNotification {

    /**
    * @var \Swift_Mailer
    */
    private $mailer;

    /**
     * @var Environment
     */
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
            $this->mailer = $mailer;
            $this->renderer = $renderer;
    }

    public function notify (Contact $contact)
    {
        // Mise en forme du mail
        $message = (new \Swift_Message('Objet_test'))
            ->setFrom($contact->getEmail())
            ->setTo('contact@alacart.fr')
            ->setReplyTo($contact->getEmail())
            ->setBody('ef');

        $this->mailer->send($message);
        

    }

}