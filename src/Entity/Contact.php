<?php 
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact {

    /**
     * @Assert\NotBlank(message="Veuillez entrer votre prénom")
     * @Assert\Length(min=2, max=100, minMessage="2 caractères minimum", maxMessage="100 caractères maximum")
     * @Assert\Type(type="string")
     */
    private $firstName;

    /**
     * @Assert\NotBlank(message="Veuillez entrer votre nom")
     * @Assert\Length(min=2, max=100, minMessage="2 caractères minimum", maxMessage="100 caractères maximum")
     * @Assert\Type(type="string")
     */
    private $lastName;

    /**
     * @Assert\Type(type="string")
     * @Assert\Regex(
     *   pattern="/[0-9{10}]/"
     * )
     */
    private $phoneNumber;

    /**
     * @Assert\NotBlank(message="Veuillez entrer votre adresse email")
     * @Assert\Type(type="string")
     * @Assert\Email()
     */
    private $email;

    /**
     * @Assert\NotBlank(message="Veuillez entrer votre message")
     * @Assert\Type(type="string")
     * @Assert\Length(min=10, minMessage="10 caractères minimum")
     */
    private $message;


    /**
     * @return null|string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param null|string $firstName
     * @return Contact
     */
    public function setFirstName(?string $firstName): Contact
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param null|string $lastName
     * @return Contact
     */
    public function setLastName(?string $lastName): Contact
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param null|string $phoneNumber
     * @return Contact
     */
    public function setPhoneNumber(?string $phoneNumber): Contact
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     * @return Contact
     */
    public function setEmail(?string $email): Contact
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param null|string $message
     * @return Contact
     */
    public function setMessage(?string $message): Contact
    {
        $this->message = $message;
        return $this;
    }
}