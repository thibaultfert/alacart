<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
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
     * @Assert\Length(max=255, maxMessage="255 caractères maximum")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     * @Assert\Length(max=500, maxMessage="500 caractères maximum")
     */
    private $images;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type(type="int")
     * @Assert\Range(
     *      min = 0,
     *      max = 10,
     *      notInRangeMessage = "Vous devez rentrer un nombre d'images compris entre 0 et 10",
     * )     
     * */
    private $numberOfImages;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max=255, maxMessage="255 caractères maximum")
     */
    private $region;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Type(type="float")     
     */
    private $volume;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Type(type="float")     
     */
    private $weight;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Veuillez entrer le prix du produit")
     * @Assert\Type(type="float")     
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez entrer le type du produit")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=ProductComment::class, mappedBy="product", orphanRemoval=true)
     */
    private $productComments;

    public function __construct()
    {
        $this->productComments = new ArrayCollection();
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

    public function setImages(?string $images): self
    {
        $this->images = $images;

        return $this;
    }

    public function getNumberOfImages(): ?int
    {
        return $this->numberOfImages;
    }

    public function setNumberOfImages(?int $numberOfImages): self
    {
        $this->numberOfImages = $numberOfImages;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
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

    public function setVolume(?float $volume): self
    {
        $this->volume = $volume;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): self
    {
        $this->weight = $weight;

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
     * @return Collection|ProductComment[]
     */
    public function getProductComments(): Collection
    {
        return $this->productComments;
    }

    public function addProductComment(ProductComment $productComment): self
    {
        if (!$this->productComments->contains($productComment)) {
            $this->productComments[] = $productComment;
            $productComment->setProduct($this);
        }

        return $this;
    }

    public function removeProductComment(ProductComment $productComment): self
    {
        if ($this->productComments->removeElement($productComment)) {
            // set the owning side to null (unless already changed)
            if ($productComment->getProduct() === $this) {
                $productComment->setProduct(null);
            }
        }

        return $this;
    }
}
