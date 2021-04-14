<?php 
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact {

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100, minMessage="2 caractères minimum", maxMessage="100 caractères maximum")
     * @Assert\Type(type="string")
     */
    private $firstName;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100, minMessage="2 caractères minimum", maxMessage="100 caractères maximum")
     * @Assert\Type(type="string")
     */
    private $lastName;

    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @Assert\Regex(
     *   pattern="/[0-9{10}]/"
     * )
     */
    private $phoneNumber;

    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @Assert\Email()
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @Assert\Length(min=10, minMessage="10 caractères minimum")
     */
    private $message;

    //video https://www.youtube.com/watch?v=BcTFEOA1Io4 à 3:09
}