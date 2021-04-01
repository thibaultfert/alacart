<?php

namespace App\Entity;

use App\Repository\DrinkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DrinkRepository::class)
 */
class Drink
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez entrer le nom du produit")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=500)
     * @Assert\NotBlank(message="Veuillez entrer le nom des images")
     * @Assert\Length(min=10, max=255, minMessage="10 caractères minimum", maxMessage="255 caractères maximum")
     * @Assert\Regex("/.jpg$/", message="Les images doivent être au format .jpg")
     */
    private $images;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez entrer la région du produit")
     * @Assert\Length(min=3, max=255, minMessage="3 caractères minimum", maxMessage="255 caractères maximum")
     */
    private $region;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(max=1000, maxMessage="1000 caractères maximum")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Veuillez entrer le volume du produit")
     * @Assert\Type(type="float")     
     */
    private $volume;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Veuillez entrer le prix du produit")
     * @Assert\Type(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez entrer le type du produit")
     * @Assert\Length(min=6, max=50)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=DrinkComment::class, mappedBy="drink", orphanRemoval=true)
     */
    private $drinkComments;

    public function __construct()
    {
        $this->drinkComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImages(): ?string
    {
        return $this->images;
    }

    public function setImages(string $images): self
    {
        $this->images = $images;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getVolume(): ?float
    {
        return $this->volume;
    }

    public function setVolume(float $volume): self
    {
        $this->volume = $volume;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|DrinkComment[]
     */
    public function getDrinkComments(): Collection
    {
        return $this->drinkComments;
    }

    public function addDrinkComment(DrinkComment $drinkComment): self
    {
        if (!$this->drinkComments->contains($drinkComment)) {
            $this->drinkComments[] = $drinkComment;
            $drinkComment->setDrink($this);
        }

        return $this;
    }

    public function removeDrinkComment(DrinkComment $drinkComment): self
    {
        if ($this->drinkComments->removeElement($drinkComment)) {
            // set the owning side to null (unless already changed)
            if ($drinkComment->getDrink() === $this) {
                $drinkComment->setDrink(null);
            }
        }

        return $this;
    }
}
