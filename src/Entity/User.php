<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez entrer votre adresse email")
     * @Assert\Length(max=255, maxMessage="255 caractères maximum")
     * @Assert\Email(message="Veuillez entrer une adresse email valide")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez entrer votre prénom")
     * @Assert\Length(max=255, maxMessage="255 caractères maximum")
     */
    private $userFirstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez entrer votre nom")
     * @Assert\Length(max=255, maxMessage="255 caractères maximum")
     */
    private $userLastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez entrer votre mot de passe")
     * @Assert\Length(min="8", minMessage="8 caractères minimum")
     * @Assert\Regex("/(?=.*[0-9])[A-Z]|(?=.*[A-Z])[0-9]/", message="Doit contenir au moins une majuscule, une minuscule et un chiffre")
     */
    private $password;

    //sans propriété ORM car n'a rien a voir avec la database
    /**
     * @Assert\NotBlank(message="Veuillez confirmer votre mot de passe")
     * @Assert\EqualTo(propertyPath="password", message="Les deux mots de passe sont différents")
     */
    private $confirm_password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUserFirstName(): ?string
    {
        return $this->userFirstName;
    }

    public function setUserFirstName(string $userFirstName): self
    {
        $this->userFirstName = $userFirstName;

        return $this;
    }

    public function getUserLastName(): ?string
    {
        return $this->userLastName;
    }

    public function setUserLastName(string $userLastName): self
    {
        $this->userLastName = $userLastName;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirm_password;
    }

    public function setConfirmPassword(string $confirm_password): self
    {
        $this->confirm_password = $confirm_password;

        return $this;
    }
}
