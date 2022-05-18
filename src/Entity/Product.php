<?php

namespace App\Entity;

use App\Entity\Picture;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\SubCategory;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

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
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="float")
     */
    private $unitPrice;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=SubCategory::class, inversedBy="product")
     */
    private $subCategory;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $material;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $diameter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $weight;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gilding;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $chainLength;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Picture::class, mappedBy="product", orphanRemoval=true, cascade={"persist"})
     */
    private $pictures;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptiontwo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptionthree;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptionfour;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptionfive;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptionsix;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): self
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSubCategory(): ?SubCategory
    {
        return $this->subCategory;
    }

    public function setSubCategory(?SubCategory $subCategory): self
    {
        $this->subCategory = $subCategory;

        return $this;
    }

    public function getMaterial(): ?string
    {
        return $this->material;
    }

    public function setMaterial(?string $material): self
    {
        $this->material = $material;

        return $this;
    }

    public function getDiameter(): ?string
    {
        return $this->diameter;
    }

    public function setDiameter(?string $diameter): self
    {
        $this->diameter = $diameter;

        return $this;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(?string $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getGilding(): ?string
    {
        return $this->gilding;
    }

    public function setGilding(?string $gilding): self
    {
        $this->gilding = $gilding;

        return $this;
    }

    public function getChainLength(): ?string
    {
        return $this->chainLength;
    }

    public function setChainLength(?string $chainLength): self
    {
        $this->chainLength = $chainLength;

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

    /**
     * @return Collection<int, Picture>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setProduct($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getProduct() === $this) {
                $picture->setProduct(null);
            }
        }

        return $this;
    }

     /**
    * toString
    * @return string
    */
    public function __toString(){

        return $this->name;
    }

    public function getDescriptiontwo(): ?string
    {
        return $this->descriptiontwo;
    }

    public function setDescriptiontwo(?string $descriptiontwo): self
    {
        $this->descriptiontwo = $descriptiontwo;

        return $this;
    }

    public function getDescriptionthree(): ?string
    {
        return $this->descriptionthree;
    }

    public function setDescriptionthree(?string $descriptionthree): self
    {
        $this->descriptionthree = $descriptionthree;

        return $this;
    }

    public function getDescriptionfour(): ?string
    {
        return $this->descriptionfour;
    }

    public function setDescriptionfour(?string $descriptionfour): self
    {
        $this->descriptionfour = $descriptionfour;

        return $this;
    }

    public function getDescriptionfive(): ?string
    {
        return $this->descriptionfive;
    }

    public function setDescriptionfive(?string $descriptionfive): self
    {
        $this->descriptionfive = $descriptionfive;

        return $this;
    }

    public function getDescriptionsix(): ?string
    {
        return $this->descriptionsix;
    }

    public function setDescriptionsix(?string $descriptionsix): self
    {
        $this->descriptionsix = $descriptionsix;

        return $this;
    }

}
