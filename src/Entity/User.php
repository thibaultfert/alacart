<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *  fields = {"email"},
 *  message = "L'email que vous avez saisi existe déjà"
 * )
 */
class User implements UserInterface
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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez entrer votre nom")
     * @Assert\Length(max=255, maxMessage="255 caractères maximum")
     */
    private $lastName;

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

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enable;

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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    // fonctions à déclarer car demandées par l'interface UserInterface
    public function eraseCredentials() {}

    public function getUsername() {
        return $this->lastName;     // Même si on se sert déjà de getUserFirstName et getUserLastName
                                    // Il faut que le composant Security accède à une donnée 'username'
                                    // ici la plus cohérente serait notre attribut lastName donc on lui fournit
    } 

    
    public function getSalt() {}

    public function getRoles() {
        return ['ROLE_USER'];
    }

    public function getEnable(): ?bool
    {
        return $this->enable;
    }

    public function setEnable(?bool $enable): self
    {
        $this->enable = $enable;

        return $this;
    }
}
